import { Button, CircularProgress, Collapse, Dialog, DialogActions, DialogContent, DialogTitle, Stack } from "@mui/material";
import { CSVLink } from 'react-csv';
import { Component } from "react";
import { withSnackbar } from "notistack";
import { ArgumentAxis, Chart, Legend, SplineSeries, ValueAxis } from '@devexpress/dx-react-chart-material-ui';  
import $ from 'jquery';


class DetailedData extends Component {
    constructor(props) {
        super(props);
        this.state = {
            loading: false,
            downloaded: false,
            graph_open: false,
            data: []
        }
    }

    async updateData() {
        this.setState({ loading: true });
        let new_data = JSON.parse( await $.get( process.env.REACT_APP_API_URL + "details" ) );
        if( new_data.success ) {
            let team0 = 0, team1 = 1;
            for( var record of new_data.data ) {
                if( record.team === "0" ) team0 = team0 + 1;
                else team1 = team1 + 1;
                record.pt0 = team0;
                record.pt1 = team1;
                record.pt_diff = team0 - team1;
                record.date = new Date( record.timestamp );
            }
            this.setState({ loading: false, downloaded: true, data: new_data.data });
            this.props.enqueueSnackbar('Dati scaricati', {variant: 'success'});
        } else {
            this.props.enqueueSnackbar('Errore non identificato', {variant: 'error'});
        }
    }

    render() {
        return (
            <Stack sx={{ my: 1 }} spacing={1} alignItems="center">
                <Button onClick={() => this.updateData() } variant="outlined">
                    { this.state.downloaded ? "Aggiorna dati" : "Scarica dati"}
                </Button>
                <CircularProgress sx={{ display: this.state.loading ? 'block' : 'none' }} />
                <Collapse
                    in={ !this.state.loading && this.state.downloaded } >
                    <CSVLink
                        data = { this.state.data }
                        headers = { [
                            { label: "ID", key: "ID" },
                            { label: "Team", key: "team" },
                            { label: "timestamp", key: "timestamp" }
                        ]}
                        filename= { "galielo_24h_gol_" + (new Date()).toISOString() + ".csv" } >
                        <Button variant="outlined" >Scarica .csv</Button>
                    </CSVLink>
                    <Button variant="outlined" onClick={ () => this.setState({ graph_open: !this.state.graph_open })}>Grafico</Button>
                    <Button variant="outlined" onClick={ () => this.setState({ graph_diff_open: !this.state.graph_diff_open })}>Differenza</Button>
                </Collapse>
                <Dialog
                    open={ this.state.graph_open }
                    onClose={ () => this.setState({ graph_open: false }) }
                    fullScreen >
                    <DialogTitle>
                        {"Grafico"}
                    </DialogTitle>
                    <DialogContent>
                        <Chart data={ this.state.data }>
                            <SplineSeries
                                name={ this.props.params['24h_team1_name'] }
                                valueField="pt0"
                                argumentField="date"
                            />
                            <SplineSeries
                                name={ this.props.params['24h_team2_name'] }
                                valueField="pt1"
                                argumentField="date"
                            />
                            <ArgumentAxis
                                tickFormat = { () => ( s ) => { let d = new Date(s); return d.getHours() + ":" + d.getMinutes(); } }
                                // To color this axis, please see global css in index.html
                                />
                            <ValueAxis
                                />
                            <Legend />
                        </Chart>
                    </DialogContent>
                    <DialogActions>
                        <Button onClick={ () => this.setState({ graph_open: false }) } autoFocus>Chiudi</Button>
                    </DialogActions>
                </Dialog>
                <Dialog
                    open={ this.state.graph_diff_open }
                    onClose={ () => this.setState({ graph_diff_open: false }) }
                    fullScreen >
                    <DialogTitle>
                        {"Grafico delle differenze ( " + this.props.params['24h_team1_name'] + " - " + this.props.params['24h_team2_name'] + ")"}
                    </DialogTitle>
                    <DialogContent>
                        <Chart data={ this.state.data }>
                            <SplineSeries
                                name={ this.props.params['24h_team1_name'] + " - " + this.props.params['24h_team2_name'] }
                                valueField="pt_diff"
                                argumentField="timestamp"
                            />
                            <ArgumentAxis 
                                showLabels={ false } 
                                showTicks ={ false }
                                />
                            <ValueAxis
                                />
                            <Legend />
                        </Chart>
                    </DialogContent>
                    <DialogActions>
                        <Button onClick={ () => this.setState({ graph_diff_open: false }) } autoFocus>Chiudi</Button>
                    </DialogActions>
                </Dialog>
            </Stack>            
        )
    }
}

export default withSnackbar(DetailedData);