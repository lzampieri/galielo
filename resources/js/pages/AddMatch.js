import { Box, Container, Grid, Typography, Button, CircularProgress, Backdrop, Tabs, Tab, Collapse, Switch } from '@material-ui/core';
import { TabContext, TabPanel } from '@material-ui/lab';
import React from 'react';
import { Link } from 'react-router-dom';
import AddMatchStepper from '../components/AddMatchStepper';
import ChartList from '../components/ChartList';
import CenteredCard from './CenteredCard';

class AddMatch extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
        }
    }

    componentDidMount() {
        this.loadPlayers();
    }

    async loadPlayers() {
        this.setState( { loading: true } );
        let u = await $.get( base_url + '/api/player/all' );
        this.setState( { players: u, loading: false } );
    }

    render() {
        return(
            <Container>
                <CenteredCard title="Aggiungi partita">
                    <AddMatchStepper players={ this.props.players } />
                </CenteredCard>                
            </Container>
        )
    }
}

export default AddMatch;
