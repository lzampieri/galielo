import { DataGrid } from '@material-ui/data-grid';
import React from 'react';

function getPoints(params) {
    return `10 - ${params.getValue(params.id, 'pt2') || 0}`;
}

function getData(params) {
    let date = new Date(params.value);
    return date.toLocaleString('it-IT', { month: '2-digit', year: 'numeric', day: '2-digit', hour: '2-digit', minute: '2-digit' });
}

function getSq1(params) {
    return `${params.getValue(params.id, 'att1')} (+${params.getValue(params.id, 'deltaa1')}), 
            ${params.getValue(params.id, 'dif1')} (+${params.getValue(params.id, 'deltad1')})`;
}

function getSq2(params) {
    return `${params.getValue(params.id, 'att2')} (${params.getValue(params.id, 'deltaa2')}), 
            ${params.getValue(params.id, 'dif2')} (${params.getValue(params.id, 'deltad2')})`;
}

const columns = [
    {
        field: 'date',
        headerName: 'Data',
        flex: 0.5,
        valueFormatter: getData
    },
    {
        field: 'Vincitori',
        headerName: 'Vincitori',
        flex: 1,
        valueGetter: getSq1
    },
    {
        field: 'Perdenti',
        headerName: 'Perdenti',
        flex: 1,
        valueGetter: getSq2
    },
    {
        field: 'points',
        headerName: 'Punti',
        flex: 0.3,
        sortable: false,
        valueGetter: getPoints
    }
];

class GamesDataGrid extends React.Component {

    constructor(props) {
        super(props);
    }

    render() {
        return(
            <DataGrid
                autoHeight
                rows={ this.props.games }
                columns={ columns }
                pageSize={ 25 }
                disableColumnMenu
                sortModel={[
                    {
                    field: 'date',
                    sort: 'desc',
                    },
                ]}
                localeText={{
                    noRowsLabel: 'Ancora nessuna partita registrata',
                    toolbarDensityLabel: 'Size',
                    toolbarDensityCompact: 'Small',
                    toolbarDensityStandard: 'Medium',
                    toolbarDensityComfortable: 'Large',
                }}
                />
        )
    }
}

export default GamesDataGrid;
