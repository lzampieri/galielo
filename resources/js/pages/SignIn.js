import React from 'react';
import SignInForm from '../components/SignInForm';
import CenteredCard from './CenteredCard';

class SignIn extends React.Component {

    constructor(props) {
        super(props);
    }

    render() {
        return(
            <CenteredCard
                title="Registrazioni"
                subtitle="Registrati per poter entrare in classifica"
                >
                <SignInForm onDone={ this.props.onDone.bind(this) } />
            </CenteredCard>
        )
    }
}

export default SignIn;
