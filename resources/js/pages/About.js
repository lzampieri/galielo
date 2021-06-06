import { Box, Container, Grid, Button, Collapse, Typography } from '@material-ui/core';
import { withStyles } from '@material-ui/styles';
import React from 'react';
import { CSVDownload, CSVLink } from 'react-csv';
import MyBackDrop from '../components/MyBackDrop';
import CenteredCard from './CenteredCard';

const style = (theme) => { return {
    codeblock: {
        backgroundColor: theme.palette.background.default,
        width: "100%",
        fontFamily: "monospace",
        whiteSpace: "pre",
        '& span': {
            color: '#a6e22e'
        }
    },
}};

class About extends React.Component {

    constructor(props) {
        super(props);
        this.state={
            loading: false,
            games: [],
            players: [],
        }
    }

    async downloadData(event,done) {
        this.setState({ loading: true });
        let res_g = await $.get( base_url + '/api/game/all' );
        let res_p = await $.get( base_url + '/api/player/all' );
        this.setState({ loading: false, games: res_g.data, players: res_p.data });
    }

    render() {
        const { classes } = this.props;
        return(
            <Container>
                <Box py={3}>
                    <CenteredCard
                        title="GitHub"
                        subtitle="Tutto il codice è disponibile pubblicamente."
                        style={ { textAlign: 'center' }}>
                            <Box
                                textAlign="center">
                                <a href="https://github.com/lzampieri/galielo" >
                                    <img src="storage/github.png" style={ { maxWidth: '200px' } } />
                                </a>
                            </Box>
                    </CenteredCard>
                    <CenteredCard
                        title="Dati"
                        subtitle="I dati sui giocatori e sulle partite sono liberamente scaricabili. La preparazione dei dati potrebbe necessitare qualche minuto, vista la grande quantità di partite da elaborare."
                        style={ { textAlign: 'center' }}>
                            <Box textAlign="center">
                                <Collapse
                                    in={ this.state.games.length == 0 }>
                                    <Button variant="outlined" onClick={ this.downloadData.bind(this) }>
                                        Prepara i dati
                                    </Button>
                                </Collapse>
                                <Collapse
                                    in={ this.state.games.length > 0 }>
                                    <CSVLink
                                        data = { this.state.players }
                                        headers = { [
                                            { label: "id", key: "id" },
                                            { label: "name", key: "name" },
                                            { label: "current_attack_points", key: "apoints" },
                                            { label: "current_defense_points", key: "dpoints"},
                                            { label: "signed_up", key: "created_at" }
                                        ]}
                                        filename= { "galielo_players_" + (new Date()).toISOString() + ".csv" }>
                                        <Button variant="outlined">Download csv giocatori</Button>
                                    </CSVLink>
                                    <CSVLink
                                        data = { this.state.games }
                                        headers = { [
                                            { label: "id", key: "id" },
                                            { label: "date", key: "date" },
                                            { label: "att_win", key: "att1_id" },
                                            { label: "delta_att_win", key: "deltaa1"},
                                            { label: "dif_win", key: "dif1_id" },
                                            { label: "delta_dif_win", key: "deltad1"},
                                            { label: "att_lose", key: "att2_id" },
                                            { label: "delta_att_lose", key: "deltaa2"},
                                            { label: "dif_lose", key: "dif2_id" },
                                            { label: "delta_dif_lose", key: "deltad2"},
                                            { label: "pt_win", key: "pt1" },
                                            { label: "pt_lose", key: "pt2" },
                                        ]}
                                        filename= { "galielo_games_" + (new Date()).toISOString() + ".csv" }>
                                        <Button variant="outlined">Download csv partite</Button>
                                    </CSVLink>
                                </Collapse>
                            </Box>
                    </CenteredCard>
                    <CenteredCard
                        title="Accesso API"
                        subtitle="La documentazione dell'accesso API è ancora in fase di elaborazione" >
                            <Box >
                                <Typography variant="h6">Accesso in visualizzazione</Typography>
                                <Box p={3} className={ classes.codeblock }>
                                    <span>Lista di tutti i giocatori</span><br/>
                                    /public/api/player/all<br/>
                                    <span>Lista di tutte le partite</span><br/>
                                    /public/api/game/all<br/>
                                    <span>Lista di tutte le partite, divise in pagine a gruppi di { this.props.params.games_pages_length }</span><br/>
                                    /public/api/game/some?page=0<br/>
                                    <span>Parametri del sito</span><br/>
                                    /public/api/param/all<br/>
                                </Box>
                            </Box>
                    </CenteredCard>
                    <CenteredCard
                        title="Log azioni"
                        subtitle="Da qui si può accedere alla lista delle azioni eseguite sul sito." >
                            <Box textAlign="center">
                                <Button
                                    variant="outlined"
                                    href={ base_url + "/log/human_readable"}>
                                    Log
                                </Button>
                            </Box>
                    </CenteredCard>
                    <MyBackDrop open={ this.state.loading } />
                </Box>
            </Container>
        )
    }
}

export default withStyles(style)(About);
