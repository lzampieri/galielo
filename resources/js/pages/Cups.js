import { Box, Container, Grid, Button } from '@material-ui/core';
import React from 'react';
import CupCard from '../components/CupCard';
import MyBackDrop from '../components/MyBackDrop';

const stats_players = [
    { title: 'Miglior giocatore', details: ' punti', sm: 4, func: (p) => ( p.apoints + p.dpoints ) / 2.0 },
    { title: 'Miglior attaccante', details: ' punti', sm: 4, func: (p) => p.apoints },
    { title: 'Miglior difensore', details: ' punti', sm: 4, func: (p) => p.dpoints },
    { title: 'Giocatore più attivo - ultimo mese', details: ' partite', sm: 6, func: (p) => ( p.asAtt1R + p.asAtt2R + p.asDif1R + p.asDif2R ) },
    { title: 'Giocatore più attivo di sempre', details: ' partite', sm: 6, func: (p) => ( p.asAtt1 + p.asAtt2 + p.asDif1 + p.asDif2 ) },
    { title: 'Giocatore più vincente - ultimo mese', details: '% di vittorie', sm: 6, func: (p) => ( p.asAtt1R + p.asDif1R == 0 ? 0 : ( p.asAtt1R + p.asDif1R ) / ( p.asAtt1R + p.asAtt2R + p.asDif1R + p.asDif2R ) * 100 ) },
    { title: 'Giocatore più vincente di sempre', details: '% di vittorie', sm: 6, func: (p) => ( p.asAtt1 + p.asDif1 == 0 ? 0 : ( p.asAtt1 + p.asDif1 ) / ( p.asAtt1 + p.asAtt2 + p.asDif1 + p.asDif2 ) * 100 ) }
]

class Cups extends React.PureComponent {

    constructor(props) {
        super(props);
        this.state = {
            bestPlayers: [],
            loading: false
        }
    }

    componentDidMount() {
        this.loadProps();
    }

    componentDidUpdate(prevProps) {
        if( this.props != prevProps )
            this.loadProps();
    }

    async loadProps() {
        this.setState({ loading: true });
        
        let bestPlayers = [];
        this.props.players.forEach( p => {
            for( let i = 0; i < stats_players.length; i++ ) {
                if( !bestPlayers[i] ||
                    stats_players[i].func( p ) > stats_players[i].func( bestPlayers[i] ) )
                    bestPlayers[i] = p;
            }
        })

        let ccups = await $.get( base_url + '/api/ccup/all' );

        this.setState({ bestPlayers: bestPlayers, ccups: ccups.data, loading: false });
    }

    cards() {
        let items = [];
        for( let i = 0; i < stats_players.length; i++ ) {
            items.push(
                <CupCard 
                    key={ i }
                    title={ stats_players[i].title }
                    details={ stats_players[i].func( this.state.bestPlayers[i] ) + stats_players[i].details }
                    sm={ stats_players[i].sm }
                >{ this.state.bestPlayers[i].name }</CupCard>
            )
        }
        return items;
    }

    getDate(date) {
        let parsed_date = new Date(date);
        return parsed_date.toLocaleDateString('it-IT', { month: '2-digit', year: 'numeric', day: '2-digit' });
    }

    render() {
        if( !this.state.bestPlayers.length ) return "";
        return(
            <Container>
                <Box py={3} my={3}>
                    <Grid container justify="center" spacing={2}>
                        { this.cards() }
                    </Grid>
                    <Grid container justify="center" spacing={2}>
                        <CupCard 
                            title={ "Coppia dei campioni" }
                            details={ "Dal " + this.getDate(this.state.ccups[ this.state.ccups.length - 1 ].date) }
                            sm={ 6 }
                        >
                            { this.state.ccups[ this.state.ccups.length - 1 ].pl1 }
                            <br/>
                            { this.state.ccups[ this.state.ccups.length - 1 ].pl2 }
                        </CupCard>
                    </Grid>
                    <Grid container justify="center" spacing={2}>
                        <Grid item xs={12} sm={4} >
                            <Button
                                href={ "mailto:galielo@altervista.org" }
                                variant="outlined"
                                style={{ width: '100%'}}
                                >
                                Suggerisci un'altra coppa
                            </Button>
                        </Grid>
                    </Grid>
                </Box>  
                <MyBackDrop open={ this.state.loading } />
            </Container>
        )
    }
}

export default Cups;
