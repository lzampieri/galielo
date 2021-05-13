import { List, ListItem, ListItemIcon, ListItemText, Collapse, Card, CardHeader, Grid } from '@material-ui/core';
import { AccountCircle } from '@material-ui/icons';
import React from 'react';
import ChartListCard from './ChartListCard';

class ChartListItem extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            collapse_open : true // Todo
        }
    }

    render() {
        let points = ( this.props.type == "A" ? this.props.p.apoints : (
                       this.props.type == "D" ? this.props.p.dpoints :
                       ( this.props.p.apoints + this.props.p.dpoints ) / 2
        ));
        return(
            <React.Fragment>
                <ListItem button
                    onClick={ () => { this.setState( { collapse_open : !this.state.collapse_open} ) } }>
                    <ListItemIcon>
                        <AccountCircle />
                    </ListItemIcon>
                    <ListItemText primary={ this.props.p.name } />
                    { points }
                </ListItem> 
                <Collapse in={ this.state.collapse_open } timeout="auto" unmountOnExit>
                    <Grid container justify="center">
                        <Grid item xs={12} sm={8}>
                            <ChartListCard p={ this.props.p }/>
                        </Grid>
                    </Grid>
                </Collapse>
            </React.Fragment>
        )
    }
}

export default ChartListItem;
