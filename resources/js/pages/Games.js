import { Box, Container, Grid, Typography, Button, CircularProgress, Backdrop, Tabs, Tab, Collapse, Switch, ButtonBase } from '@material-ui/core';
import React from 'react';
import { CSVLink } from 'react-csv';
import GamesDataGrid from '../components/GamesDataGrid';
import CenteredCard from './CenteredCard';

class Games extends React.Component {

    constructor(props) {
        super(props);
    }

    render() {
        return(
            <Container>
                <CenteredCard title="Partite" sm={10}>
                    <GamesDataGrid games={ this.props.games }/>
                    <Box pt={3}>
                    <Typography variant="body1">Al momento ci sono { this.props.games.length } partite inserite nel sistema. L'elenco completo si può scaricare come <CSVLink
                            data = { this.props.games }
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
                            filename= { "galielo_games_" + (new Date()).toISOString() + ".csv" }
                            style={{ color: "white" }}
                            >csv</CSVLink>
                        </Typography>
                    </Box>
                </CenteredCard>
            </Container>
        )
    }
}

export default Games;
