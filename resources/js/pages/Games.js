import { Box, Container, Grid, Typography, Button, CircularProgress, Tabs, Tab, Collapse, Switch, ButtonBase } from '@material-ui/core';
import React from 'react';
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
                    <GamesDataGrid />
                    <Box pt={3}>
                    </Box>
                </CenteredCard>
            </Container>
        )
    }
}

export default Games;
