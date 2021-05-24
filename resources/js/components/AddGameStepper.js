import { Backdrop, Box, Button, CircularProgress, List, ListItem, ListItemIcon, ListItemText, Slider, Step, StepContent, StepLabel, Stepper, Typography } from '@material-ui/core';
import { AccountCircle, SwapVert } from '@material-ui/icons';
import { Alert } from '@material-ui/lab';
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

class AddGameStepper extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            currentStep: 0,
            selectedSqGreen: [],
            selectedSqRed:   [],
            redPoints: 0,
            loading: false,
            error: undefined,
            result: undefined
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

    savedList() {
        const { classes } = this.props;
        if( this.state.error || !this.state.result )
            return (<Alert severity="error">{this.state.error || "Impossibile recuperare i dati della partita"}</Alert>);
        return (
            <List>
                <ListItem className={classes.greenSquad}>
                    <ListItemIcon>
                        <AccountCircle />
                    </ListItemIcon>
                    <ListItemText primary={ this.state.result.att1 } secondary="Attaccante" />
                    <Typography variant="h4">+{ this.state.result.deltaa1 }</Typography>
                </ListItem>
                <ListItem className={classes.greenSquad}>
                    <ListItemIcon>
                        <AccountCircle />
                    </ListItemIcon>
                    <ListItemText primary={ this.state.result.dif1 } secondary="Difensore" />
                    <Typography variant="h4">+{ this.state.result.deltad1 }</Typography>
                </ListItem>
                <ListItem>
                    <ListItemText/>
                    <Typography variant="h4">10 - { this.state.result.pt2 }</Typography>
                </ListItem>
                <ListItem className={classes.redSquad}>
                    <ListItemIcon>
                        <AccountCircle />
                    </ListItemIcon>
                    <ListItemText primary={ this.state.result.att2 } secondary="Attaccante" />
                    <Typography variant="h4">{ this.state.result.deltaa2 }</Typography>
                </ListItem>
                <ListItem className={classes.redSquad}>
                    <ListItemIcon>
                        <AccountCircle />
                    </ListItemIcon>
                    <ListItemText primary={ this.state.result.dif2 } secondary="Difensore" />
                    <Typography variant="h4">{ this.state.result.deltad2 }</Typography>
                </ListItem>
            </List>
        )
    }

    async saveData() {
        this.setState({ loading: true });
        let values = {
            _token: csrfmiddlewaretoken,
            att1: this.state.selectedSqGreen[0].id,
            dif1: this.state.selectedSqGreen[1].id,
            att2: this.state.selectedSqRed  [0].id,
            dif2: this.state.selectedSqRed  [1].id,
            points: this.state.redPoints
        }
        let result = await $.post( base_url + '/api/game', values );
        this.setState({ loading: false, currentStep: 4 });
        if( result.success ) {
            await this.props.onDone();
            this.setState({ result: result });
        } else {
            this.setState({ error: result.errorInfo[2] });
        }
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
                        { this.savedList() }
                        <Button
                            onClick = { () => this.setState({ currentStep: 0, selectedSqGreen: [], selectedSqRed: [] }) }
                            variant="outlined">
                            Aggiungi un'altra
                        </Button>
                    </StepContent>
                </Step>
                <Backdrop style={{ zIndex: 1500 }} open={ this.state.loading > 0 }>
                    <CircularProgress />
                </Backdrop>
            </Stepper>
        )
    }
}

export default withStyles(styles)(AddGameStepper);
