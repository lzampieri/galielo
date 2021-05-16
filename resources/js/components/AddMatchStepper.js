import { Backdrop, Box, Button, CircularProgress, List, ListItem, ListItemIcon, ListItemText, Slider, Step, StepContent, StepLabel, Stepper, Typography } from '@material-ui/core';
import { AccountCircle, SwapVert } from '@material-ui/icons';
import { withStyles } from '@material-ui/styles';
import React from 'react';

const styles = (theme) => { return {
    greenSquad: {
        backgroundColor: 'green !important',
    },
    redSquad: {
        backgroundColor: 'red !important',
    },
}};

class AddMatchStepper extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            currentStep: 0,
            selectedSqGreen: [],
            selectedSqRed:   [],
            redPoints: 0,
            loading: false
        }
    }

    componentDidMount() {
    }

    handlePlayerSelection( p ) {
        let sqGreen = this.state.selectedSqGreen;
        let sqRed =  this.state.selectedSqRed;
        if( sqGreen.includes( p ) ) {
            sqGreen.splice( sqGreen.indexOf( p ), 1);
            sqRed.push( p );
        }
        else if( sqRed.includes( p ) ) {
            sqRed.splice( sqRed.indexOf( p ), 1);
        }
        else {
            sqGreen.push( p );
        }
        this.setState( {
            selectedSqGreen: sqGreen,
            selectedSqRed: sqRed
        });
    }

    playersList() {
        const { classes } = this.props;
        return (
            <List>
                { this.props.players.map( p => (
                    <ListItem
                        button
                        className={ this.state.selectedSqGreen.includes( p ) ? classes.greenSquad : (
                            this.state.selectedSqRed.includes( p ) ? classes.redSquad : null ) }
                        key={ p.id }
                        onClick={ () => this.handlePlayerSelection( p ) }
                        >
                        <ListItemIcon>
                            <AccountCircle />
                        </ListItemIcon>
                        <ListItemText primary={ p.name } />
                    </ListItem>
                ))}
            </List>
        );

    }

    rolesList() {
        const { classes } = this.props;
        return (
            <List>
                <ListItem className={classes.greenSquad}>
                    <ListItemIcon>
                        <AccountCircle />
                    </ListItemIcon>
                    <ListItemText primary={ this.state.selectedSqGreen[0] && this.state.selectedSqGreen[0].name } secondary="Attaccante" />
                </ListItem>
                <ListItem button className={classes.greenSquad}
                    onClick={() => this.setState( {
                        selectedSqGreen: [ this.state.selectedSqGreen[1], this.state.selectedSqGreen[0] ]
                    })}>
                    <ListItemIcon>
                        <SwapVert />
                    </ListItemIcon>
                </ListItem>
                <ListItem className={classes.greenSquad}>
                    <ListItemIcon>
                        <AccountCircle />
                    </ListItemIcon>
                    <ListItemText primary={ this.state.selectedSqGreen[1] && this.state.selectedSqGreen[1].name } secondary="Difensore" />
                </ListItem>

                <ListItem className={classes.redSquad}>
                    <ListItemIcon>
                        <AccountCircle />
                    </ListItemIcon>
                    <ListItemText primary={ this.state.selectedSqRed[0] && this.state.selectedSqRed[0].name } secondary="Attaccante" />
                </ListItem>
                <ListItem button className={classes.redSquad}
                    onClick={() => this.setState( {
                        selectedSqRed: [ this.state.selectedSqRed[1], this.state.selectedSqRed[0] ]
                    })}>
                    <ListItemIcon>
                        <SwapVert />
                    </ListItemIcon>
                </ListItem>
                <ListItem className={classes.redSquad}>
                    <ListItemIcon>
                        <AccountCircle />
                    </ListItemIcon>
                    <ListItemText primary={ this.state.selectedSqRed[1] && this.state.selectedSqRed[1].name } secondary="Difensore" />
                </ListItem>
            </List>
        );
    }

    points() {
        const { classes } = this.props;
        return (
            <React.Fragment>
                <Typography variant="body2">
                    Si ricorda che, per una vittoria ai vantaggi, è da considerarsi un punteggio di 10-9.
                </Typography>
                <Typography variant="overline">
                    Squadra vincente
                </Typography>
                <Slider
                    className={ classes.greenSquad }
                    defaultValue={10}
                    disabled={ true }
                    valueLabelDisplay="on"
                    min={0}
                    max={10}
                    step={1}
                    marks
                    />     
                <Typography variant="overline">
                    Squadra perdente
                </Typography>
                <Slider
                    className={ classes.redSquad }
                    valueLabelDisplay="on"
                    onChange={ (event, value) => this.setState({ redPoints: value }) }
                    value={ this.state.redPoints }
                    min={0}
                    max={10}
                    step={1}
                    />
            </React.Fragment>
        )
    }

    confirmList() {
        const { classes } = this.props;
        return (
            <List>
                <ListItem className={classes.greenSquad}>
                    <ListItemIcon>
                        <AccountCircle />
                    </ListItemIcon>
                    <ListItemText primary={ this.state.selectedSqGreen[0] && this.state.selectedSqGreen[0].name } secondary="Attaccante" />
                    <Typography variant="h4">10</Typography>
                </ListItem>
                <ListItem className={classes.greenSquad}>
                    <ListItemIcon>
                        <AccountCircle />
                    </ListItemIcon>
                    <ListItemText primary={ this.state.selectedSqGreen[1] && this.state.selectedSqGreen[1].name } secondary="Difensore" />
                </ListItem>

                <ListItem className={classes.redSquad}>
                    <ListItemIcon>
                        <AccountCircle />
                    </ListItemIcon>
                    <ListItemText primary={ this.state.selectedSqRed[0] && this.state.selectedSqRed[0].name } secondary="Attaccante" />
                    <Typography variant="h4">{ this.state.redPoints }</Typography>
                </ListItem>
                <ListItem className={classes.redSquad}>
                    <ListItemIcon>
                        <AccountCircle />
                    </ListItemIcon>
                    <ListItemText primary={ this.state.selectedSqRed[1] && this.state.selectedSqRed[1].name } secondary="Difensore" />
                </ListItem>
            </List>
        )
    }

    saveData() {
        this.setState({ loading: true });
    }

    render() {
        return(
            <Stepper activeStep={ this.state.currentStep } orientation="vertical">
                <Step key="select_players">
                    <StepLabel>Seleziona giocatori</StepLabel>
                    <StepContent>
                        <Typography variant="body2">Un click per inserire nella squadra verde, due click per quella rossa.</Typography>
                        { this.playersList() }
                        <Button
                            disabled = { true }
                            variant="outlined">
                            Indietro
                        </Button>
                        <Button
                            disabled = { this.state.selectedSqGreen.length == 2 && this.state.selectedSqRed.length == 2 ? false : true }
                            onClick = { () => this.setState( { currentStep: 1 } ) }
                            variant="outlined">
                            Avanti
                        </Button>
                    </StepContent>
                </Step>
                <Step key="select_roles">
                    <StepLabel>Seleziona ruoli</StepLabel>
                    <StepContent>
                        { this.rolesList() }
                        <Button
                            onClick = { () => this.setState( { currentStep: 0 } ) }
                            variant="outlined">
                            Indietro
                        </Button>
                        <Button
                            onClick = { () => this.setState( { currentStep: 2 } ) }
                            variant="outlined">
                            Avanti
                        </Button>
                    </StepContent>
                </Step>
                <Step key="select_points">
                    <StepLabel>Seleziona punteggi</StepLabel>
                    <StepContent>
                        { this.points() }
                        <Button
                            onClick = { () => this.setState( { currentStep: 1 } ) }
                            variant="outlined">
                            Indietro
                        </Button>
                        <Button
                            onClick = { () => this.setState( { currentStep: 3 } ) }
                            disabled = { this.state.redPoints == 10 }
                            variant="outlined">
                            Avanti
                        </Button>
                    </StepContent>
                </Step>
                <Step key="confirm">
                    <StepLabel>Conferma</StepLabel>
                    <StepContent>
                        { this.confirmList() }
                        <Button
                            onClick = { () => this.setState( { currentStep: 2 } ) }
                            variant="outlined">
                            Indietro
                        </Button>
                        <Button
                            onClick = { () => this.saveData() }
                            variant="outlined">
                            Salva
                        </Button>
                    </StepContent>
                </Step>
                <Step key="saved">
                    <StepLabel>Salvato</StepLabel>
                    <StepContent>
                        Qui la lista dei giocatori...
                        <Button>Avanti</Button>
                    </StepContent>
                </Step>
                <Backdrop style={{ zIndex: 1500 }} open={ this.state.loading > 0 }>
                    <CircularProgress />
                </Backdrop>
            </Stepper>
        )
    }
}

export default withStyles(styles)(AddMatchStepper);
