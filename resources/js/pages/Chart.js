import { Box, Container, Grid, Typography, Button, CircularProgress, Backdrop, Tabs, Tab, Collapse, Switch } from '@material-ui/core';
import { TabContext, TabPanel } from '@material-ui/lab';
import { withStyles } from '@material-ui/styles';
import React from 'react';
import { Link } from 'react-router-dom';
import ChartList from '../components/ChartList';
import CenteredCard from './CenteredCard';

const style = (theme) => { return {
    word: {
        fontWeight: 'bolder',
        fontSize: theme.typography.h4.fontSize
    },
    type: {
        fontWeight: 'bolder',
        color: theme.palette.text.disabled
    },
    origin: {
        color: theme.palette.text.disabled
    },
    origin_word: {
        fontStyle: 'italic'
    },
    def: {
        color: theme.palette.text.secondary
    }
}};

class Chart extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            selected_tab: 2,
            sleepers: false
        }
    }

    swipe_tab(event, newValue) {
        this.setState( { selected_tab: newValue } );
    }

    swipe_view(index) {
        this.setState( { selected_tab: index } );
    }

    header_cit() {
        const { classes } = this.props;
        return (
            <React.Fragment>
            <Typography variant="subtitle1">
                <span className={ classes.word }>rankare </span>
                <span className={ classes.type }>v.tr. </span>
                <span className={ classes.origin }>[dall'inglese <span className={ classes.origin_word }>rank</span>, classificare, ovvero  dal protogermanico <span className={ classes.origin_word }>hringaz</span>, anello] (aus. <span className={ classes.origin_word }>avere</span>)</span>
                <span className={ classes.def }> &mdash; concedere dignità ad un incontro (partita) inserendolo in apposito database, atto a gestire una classifica dei giocatori.</span>
            </Typography>
            </React.Fragment>
        )
    }

    render() {
        return(
            <Container>
                <Box py={3}>
                    <Grid container spacing={3} justify="center" alignItems="center">
                        <Grid item xs={10} sm={4}>
                            <img src="storage/logo_large.png" width="100%" />
                        </Grid>
                        <Grid item xs={10} sm={4}>
                            { this.header_cit() }
                            <br/>
                            <Button
                                to="sign-in"
                                component={Link}
                                variant="outlined">
                                Registrati
                            </Button>
                            { this.props.logged ? (    
                                <Button
                                    to="add-game"
                                    component={Link}
                                    variant="outlined">
                                    Aggiungi partita
                                </Button>
                            ) :  (    
                                <Button
                                    to="login"
                                    href={ base_url + "/auth/login_google" }
                                    variant="outlined">
                                    Login
                                </Button>
                            )}
                        </Grid>
                    </Grid>
                </Box>
                <CenteredCard title="Classifica" >
                        <Box display="flex" justifyContent="flex-end" alignItems="center">
                            <Typography variant="button">Inattivi</Typography>
                            <Switch checked={ this.state.sleepers }
                                    onChange={ (event) => this.setState({ sleepers: !this.state.sleepers}) } />
                        </Box>
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
                            <ChartList players={ this.props.players } sleepers={ this.state.sleepers } type='A' />
                        </Collapse>
                        <Collapse in={ this.state.selected_tab == 1 }>
                            <ChartList players={ this.props.players } sleepers={ this.state.sleepers } type='D' />
                        </Collapse>
                        <Collapse in={ this.state.selected_tab == 2 } >
                            <ChartList players={ this.props.players } sleepers={ this.state.sleepers } type='T' />
                        </Collapse>
                </CenteredCard>
            </Container>
        )
    }
}

export default withStyles(style)(Chart);
