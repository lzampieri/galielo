import { List, ListItem } from '@material-ui/core';
import React from 'react';
import ChartListItem from './ChartListItem';

class ChartList extends React.Component {

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

    render() {
        return(
            <List style={{ width: "100%" }}>
                { this.state.sorted.map( p => <ChartListItem p = {p} key = {p.id} type = {this.props.type} sleeper = {this.props.sleepers} /> ) }
            </List>
        )
    }
}

export default ChartList;
