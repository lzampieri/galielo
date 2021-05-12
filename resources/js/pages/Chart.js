import { Box, Container, Grid, Typography, Button } from '@material-ui/core';
import React from 'react';
import { Link } from 'react-router-dom';
import CenteredCard from './CenteredCard';

class Chart extends React.Component {

    constructor(props) {
        super(props);
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
                    ChartList
                </CenteredCard>
            </Container>
        )
    }
}

export default Chart;
