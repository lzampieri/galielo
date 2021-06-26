import { List, ListItem, ListItemIcon, ListItemText, Collapse, Card, CardHeader, Grid } from '@material-ui/core';
import { AccountCircle } from '@material-ui/icons';
import React from 'react';
import ParamsContext from '../ParamsContext';
import ChartListCard from './ChartListCard';
import { Bed, Blender, ChessQueen} from 'mdi-material-ui';
import GalieloPlayer from './GalieloPlayer';

class ChartListItem extends React.PureComponent {

    constructor(props) {
        super(props);
        this.state = {
            collapse_open : false
        }
    }

    getAvatar( p, points, type, context ) {
        // Check if sleeper
        if ( 
            ( ( p.asAtt1R + p.asAtt2R ) * ( 1 - ( type == 'D' )) + 
            ( p.asDif1R + p.asDif2R ) * ( 1 - ( type == 'A' )) ) <
            context.active_threshold )
            return <Bed />
        if (
            points >= context.crown_threshold
        ) return <ChessQueen />;
        if (
            points <= context.blender_threshold
        ) return <Blender />;
        return <GalieloPlayer />;
    }    

    render() {
        let p = this.props.p;
        let type = this.props.type;
        let points = ( type == "A" ? p.apoints : (
                       type == "D" ? p.dpoints :
                       ( p.apoints + p.dpoints ) / 2
        ));
        return(
            <React.Fragment>
                <ListItem
                    button onClick={ () => { this.setState( { collapse_open : !this.state.collapse_open} ) } }>
                    <ListItemIcon>
                        { this.getAvatar( p, points, type, this.context ) }
                    </ListItemIcon>
                    <ListItemText primary={ p.name } />
                    { points }
                </ListItem> 
                <Collapse in={ this.state.collapse_open } mountOnEnter unmountOnExit>
                    <Grid container justify="center">
                        <Grid item xs={12} sm={8}>
                            <ChartListCard p={ p }/>
                        </Grid>
                    </Grid>
                </Collapse>
            </React.Fragment>
        )
    }
}

ChartListItem.contextType = ParamsContext;

export default ChartListItem;
