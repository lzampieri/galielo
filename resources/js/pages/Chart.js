import { Box, Container, Grid, Typography, Button, CircularProgress, Backdrop, Tabs, Tab, Collapse } from '@material-ui/core';
import { TabContext, TabPanel } from '@material-ui/lab';
import React from 'react';
import { Link } from 'react-router-dom';
import ChartList from '../components/ChartList';
import CenteredCard from './CenteredCard';

class Chart extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            loading: false,
            players: [],
            selected_tab: 2
        }
    }

    componentDidMount() {
        this.loadPlayers();
    }

    async loadPlayers() {
        this.setState( { loading: true } );
        let u = await $.get( base_url + '/api/player/all' )
        this.setState( { players: u, loading: false } );
    }

    swipe_tab(event, newValue) {
        this.setState( { selected_tab: newValue } );
    }

    swipe_view(index) {
        this.setState( { selected_tab: index } );
    }

    render() {
        const { classes } = this.props;
        return(
            <Container>
                <Box py={3}>
                    <Grid container spacing={3} justify="center" alignItems="center">
                        <Grid item xs={10} sm={4}>
                            <img src="storage/logo_large.png" width="100%" />
                        </Grid>
                        <Grid item xs={10} sm={4}>
                            <Typography variant="h5">
                                Perché nessuno ranka come un galileiano.
                            </Typography>
                            <br/>
                            <Button
                                to="sign-in"
                                component={Link}
                                variant="outlined">
                                Registrati
                            </Button>
                        </Grid>
                    </Grid>
                </Box>
                <CenteredCard title="Classifica" >
                        <Tabs
                            value={ this.state.selected_tab }
                            onChange={ this.swipe_tab.bind(this) }
                            variant="fullWidth"
                        >
                            <Tab label="Attacco" value={0} />
                            <Tab label="Difesa" value={1} />
                            <Tab label="Totale" value={2} />
                        </Tabs>
                        <Collapse in={ this.state.selected_tab == 0 }>
                            <ChartList players={ [] } />
                        </Collapse>
                        <Collapse in={ this.state.selected_tab == 1 }>
                            <ChartList players={ this.state.players } />
                        </Collapse>
                        <Collapse in={ this.state.selected_tab == 2 }>
                            <ChartList players={ [] } />
                        </Collapse>
                </CenteredCard>
                <Backdrop style={{ zIndex: 1500 }} open={ this.state.loading }>
                    <CircularProgress />
                </Backdrop>
            </Container>
        )
    }
}

export default Chart;
