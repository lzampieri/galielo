import { Container } from '@material-ui/core';
import React from 'react';
import AddGameStepper from '../components/AddGameStepper';
import CenteredCard from './CenteredCard';

class AddGame extends React.Component {

    constructor(props) {
        super(props);
    }

    render() {
        return(
            <Container>
                <CenteredCard title="Aggiungi partita" subtitle="Definisci le squadre vincente (verde) e perdente (rossa)">
                    <AddGameStepper players={ this.props.players } onDone={ this.props.onDone.bind(this) } />
                </CenteredCard>                
            </Container>
        )
    }
}

export default AddGame;
