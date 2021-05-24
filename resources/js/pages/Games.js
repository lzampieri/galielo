import { Box, Container, Grid, Typography, Button, CircularProgress, Backdrop, Tabs, Tab, Collapse, Switch } from '@material-ui/core';
import { TabContext, TabPanel } from '@material-ui/lab';
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
                <CenteredCard title="Partite">
                    <GamesDataGrid games={ this.props.games } />
                </CenteredCard>
            </Container>
        )
    }
}

export default Games;
