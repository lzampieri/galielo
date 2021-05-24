import { DataGrid } from '@material-ui/data-grid';
import React from 'react';

function getPoints(params) {
    return `${params.getValue('pt2') || ''}`;
}

const columns = [
    {
        field: 'date',
        headerName: 'Data',
        flex: 0.3
    },
    {
        field: 'att1',
        headerName: 'Vincitori',
        flex: 1,
    },
    {
        field: 'att2',
        headerName: 'Perdenti',
        flex: 1,
    },
    {
        field: 'points',
        headerName: 'Punteggio',
        flex: 0.3,
        valueGetter: getPoints
    }
];

class GamesDataGrid extends React.Component {

    constructor(props) {
        super(props);
    }

    // getDate( params ) {
    //     return params.getValue('date');
    // }
    // getWinners( params ) {
    //     return params.getValue('att1');
    // }
    // getLosers( params ) {
    //     return params.getValue('att2');
    // }

    render() {
        return(
            <DataGrid
                autoHeight
                rows={ this.props.games }
                columns={ columns }
                pageSize={ 25 }
                />
        )
    }
}

export default GamesDataGrid;
