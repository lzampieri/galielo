import { ListItem, ListItemAvatar, ListItemText } from '@material-ui/core';
import { AccountCircle } from '@material-ui/icons';
import { Skeleton } from '@material-ui/lab';
import React from 'react';
import ParamsContext from '../ParamsContext';

// function getPoints(params) {
//     return `10 - ${params.getValue(params.id, 'pt2') || 0}`;
// }

// function getData(params) {
//     let date = new Date(params.value);
//     let date_string = date.toLocaleString('it-IT', { month: '2-digit', year: 'numeric', day: '2-digit', hour: '2-digit', minute: '2-digit' });
//     let table = params.getValue(params.id, 'table');
//     return date_string + ", " + table;
// }

// function getSq1(params) {
//     return `${params.getValue(params.id, 'att1')} (+${params.getValue(params.id, 'deltaa1')}), 
//             ${params.getValue(params.id, 'dif1')} (+${params.getValue(params.id, 'deltad1')})`;
// }

// function getSq2(params) {
//     return `${params.getValue(params.id, 'att2')} (${params.getValue(params.id, 'deltaa2')}), 
//             ${params.getValue(params.id, 'dif2')} (${params.getValue(params.id, 'deltad2')})`;
// }

// const columns = [
//     {
//         field: 'date',
//         headerName: 'Data e luogo',
//         flex: 0.5,
//         valueFormatter: getData,
//         sortable: false
//     },
//     {
//         field: 'Vincitori',
//         headerName: 'Vincitori',
//         flex: 1,
//         valueGetter: getSq1,
//         sortable: false
//     },
//     {
//         field: 'Perdenti',
//         headerName: 'Perdenti',
//         flex: 1,
//         valueGetter: getSq2,
//         sortable: false
//     },
//     {
//         field: 'points',
//         headerName: 'Punti',
//         flex: 0.3,
//         valueGetter: getPoints,
//         sortable: false
//     }
// ];

class GamesDataListItem extends React.Component {

    constructor(props) {
        super(props);
    }

    componentDidMount() {
    }

    render() {
        return(
                <ListItem style={ this.props.style }>
                    <ListItemAvatar>
                        { this.props.game ? <AccountCircle /> : <Skeleton variant="circle" width={40} height={40}  animation="wave" /> }
                    </ListItemAvatar>
                    <ListItemText primary={ this.props.index } secondary={ this.props.game && this.props.game.id } />
                </ListItem>
        )
    }
}

GamesDataListItem.contextType = ParamsContext;

export default GamesDataListItem;
