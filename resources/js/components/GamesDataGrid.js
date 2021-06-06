import { CircularProgress } from '@material-ui/core';
import { DataGrid } from '@material-ui/data-grid';
import React from 'react';
import MyBackDrop from './MyBackDrop';

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
        valueFormatter: getData,
        sortable: false
    },
    {
        field: 'Vincitori',
        headerName: 'Vincitori',
        flex: 1,
        valueGetter: getSq1,
        sortable: false
    },
    {
        field: 'Perdenti',
        headerName: 'Perdenti',
        flex: 1,
        valueGetter: getSq2,
        sortable: false
    },
    {
        field: 'points',
        headerName: 'Punti',
        flex: 0.3,
        valueGetter: getPoints,
        sortable: false
    }
];

class GamesDataGrid extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            pageSize: 0,
            rowCount: 0,
            page: 0,
            games: [],
            loading: true
        }
    }

    componentDidMount() {
        this.downloadPage();
    }

    componentDidUpdate(lastProps, lastState) {
        if( lastState.page != this.state.page )
            this.downloadPage();
    }

    handlePageChange(params) {
        this.setState({ page: params.page });
    }

    async downloadPage() {
        this.setState({ loading: true });
        let res = await $.get( base_url + '/api/game/some?page=' + ( this.state.page + 1 ) );
        console.log( base_url + '/api/game/some?page=' + ( this.state.page + 1 ) );
        this.setState({
            loading: false,
            games: res.data,
            rowCount: res.meta.total,
            pageSize: parseInt(res.meta.per_page)
        })
    }

    render() {
        return(
            <DataGrid
                autoHeight
                rows={ this.state.games }
                columns={ columns }
                disableColumnMenu
                localeText={{
                    noRowsLabel: 'Ancora nessuna partita registrata',
                    toolbarDensityLabel: 'Size',
                    toolbarDensityCompact: 'Small',
                    toolbarDensityStandard: 'Medium',
                    toolbarDensityComfortable: 'Large',
                }}

                pagination
                pageSize={ this.state.pageSize }
                rowCount={ this.state.rowCount }
                onPageChange={ this.handlePageChange.bind(this) }
                loading={ this.state.loading }
                paginationMode="server"
                rowsPerPageOptions={[]}
                />
        )
    }
}

export default GamesDataGrid;
