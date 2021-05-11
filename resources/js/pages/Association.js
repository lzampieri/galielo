import React from 'react';
import UserSelectForm from '../components/UserSelectForm';
import CenteredCard from './CenteredCard';

class Association extends React.Component {

    constructor(props) {
        super(props);
    }

    render() {
        return(
            <CenteredCard
                title="Associa utente"
                subtitle="Seleziona il tuo utente da associare all'account">
                <UserSelectForm onDone={ this.props.onDone.bind(this) }/>
            </CenteredCard>
        )
    }
}

export default Association;
