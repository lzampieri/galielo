import { Button, List, ListItem, ListItemIcon, ListItemText, Step, StepContent, StepLabel, Stepper, Typography } from '@material-ui/core';
import { AccountCircle } from '@material-ui/icons';
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
            currentStep: 0
        }
    }

    componentDidMount() {
    }

    handlePlayerSelection(id) {
        return id;
    }

    playersList() {
        const { classes } = this.props;
        return (
            <List>
                { this.props.players.map( p => (
                    <ListItem
                        button
                        className={ classes.redSquad }
                        key={ p.id }
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

    render() {
        return(
            <Stepper activeStep={ this.state.currentStep } orientation="vertical">
                <Step key="select_players">
                    <StepLabel>Seleziona giocatori</StepLabel>
                    <StepContent>
                        <Typography variant="body2">Un click per inserire nella squadra verde (vincente), due click per quella rossa (perdente).</Typography>
                        { this.playersList() }
                        <Button>Avanti</Button>
                    </StepContent>
                </Step>
                <Step key="select_roles_points">
                    <StepLabel>Seleziona ruoli</StepLabel>
                    <StepContent>
                        Qui la lista dei giocatori...
                        <Button>Avanti</Button>
                    </StepContent>
                </Step>
                <Step key="confirm">
                    <StepLabel>Conferma</StepLabel>
                    <StepContent>
                        Qui la lista dei giocatori...
                        <Button>Avanti</Button>
                    </StepContent>
                </Step>
                <Step key="saved">
                    <StepLabel>Salvato</StepLabel>
                    <StepContent>
                        Qui la lista dei giocatori...
                        <Button>Avanti</Button>
                    </StepContent>
                </Step>
            </Stepper>
        )
    }
}

export default withStyles(styles)(AddMatchStepper);
