import { List, ListItem } from '@material-ui/core';
import React from 'react';
import ChartListItem from './ChartListItem';

class ChartList extends React.Component {

    constructor(props) {
        super(props);
    }

    render() {
        return(
            <List style={{ width: "100%" }}>
                { this.props.players.map( p => <ChartListItem p = {p} key = {p.id} /> ) }
            </List>
        )
    }
}

export default ChartList;
