import { List, Box, Collapse } from '@material-ui/core';
import React from 'react';
import ChartListItem from './ChartListItem';
import ParamsContext from '../ParamsContext';

class ChartList extends React.PureComponent {

    constructor(props) {
        super(props);
        this.state = {
            sorted: []
        }
    }

    componentDidMount() {
        this.sortPlayers();
    }

    componentDidUpdate(prevProps) {
        if( this.props.players !== prevProps.players ) {
            this.sortPlayers();
        }
    }

    sortPlayers() {
        let to_sort = [...this.props.players]; // Array is fully copied, to have a editable version
        let type = this.props.type;
        to_sort.sort( function(a,b) {
            return b.apoints * ( 1 - ( type == 'D' )) + b.dpoints * ( 1 - ( type == 'A' ))
                 - a.apoints * ( 1 - ( type == 'D' )) - a.dpoints * ( 1 - ( type == 'A' )) ;
        });
        this.setState( {
            sorted: to_sort
        });
    }

    visible(p) {
        let type = this.props.type;
        return this.props.sleepers || ( ( p.asAtt1R + p.asAtt2R ) * ( 1 - ( type == 'D' )) + ( p.asDif1R + p.asDif2R ) * ( 1 - ( type == 'A' )) ) >= this.context.active_threshold;
    }

    render() {
        return(
            <Box style={{ width: "100%" }}>
                { this.state.sorted.map( p => (
                    <Collapse in={ this.visible(p) } key = {p.id}>
                        <ChartListItem p = {p} type = {this.props.type} />
                    </Collapse> 
                ) ) }
            </Box>
        )
    }
}

ChartList.contextType = ParamsContext;

export default ChartList;
