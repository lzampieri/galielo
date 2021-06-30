import { Container } from '@material-ui/core';
import { Alert } from '@material-ui/lab';
import { withStyles } from '@material-ui/styles';
import React from 'react';
import { withRouter } from 'react-router-dom';
import MyBackDrop from '../components/MyBackDrop';
import CenteredCard from './CenteredCard';

const style = (theme) => { return {
    
}};

class Player extends React.PureComponent {

    constructor(props) {
        super(props);
        this.state = {
            loading: true,
            playerDetails: {}
        }
    }

    componentDidMount() {
        this.loadPlayer();
    }

    componentDidUpdate(prevProps) {
        if( this.props.match.params.id != prevProps.match.params.id )
            this.loadPlayer();
    }

    async loadPlayer() {
        this.setState({ loading: true });
        let p = await $.get( base_url + '/api/player/' + this.props.match.params.id );
        this.setState({
            playerDetails: p.data || {},
            loading: false
        })
    }

    render() {
        return(
            <Container>
                <CenteredCard
                    title={ this.state.playerDetails.name }
                    subtitle={ this.props.match.params.id }>
                    { this.state.playerDetails.name ? "Dettagli del giocatore" : (
                        <Alert severity="error">{"Impossibile recuperare il giocatore selezionato"}</Alert>
                    )}
                </CenteredCard>
                <MyBackDrop open={ this.state.loading } />
            </Container>
        )
    }
}

export default withRouter(withStyles(style)(Player));
