import { Box, Container, Grid, Typography, Button, CircularProgress, Backdrop } from '@material-ui/core';
import React from 'react';
import { Link } from 'react-router-dom';
import CenteredCard from './CenteredCard';

class Chart extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            loading: false,
            players: []
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
                <CenteredCard>
                    { this.state.players.map( p => p.name ) }
                </CenteredCard>
                <Backdrop style={{ zIndex: 1500 }} open={ this.state.loading }>
                    <CircularProgress />
                </Backdrop>
            </Container>
        )
    }
}

export default Chart;
