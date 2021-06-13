import { Box, Container, Grid, Typography, Button, CircularProgress, Tabs, Tab, Collapse, Switch, ButtonBase } from '@material-ui/core';
import React from 'react';
import { Link } from 'react-router-dom';
import GamesDataList from '../components/GamesDataList';
import CenteredCard from './CenteredCard';

class Games extends React.Component {

    constructor(props) {
        super(props);
    }

    render() {
        return(
            <Container>
                <CenteredCard title="Partite" sm={10}>
                    <Grid container justify="flex-end">
                        { this.props.logged ?   
                                <Button
                                    to="add-game"
                                    component={Link}
                                    variant="outlined">
                                    Aggiungi partita
                                </Button>
                             :  (    
                                "Effettua il login per inserire una partita"
                            )}
                    </Grid>
                    <GamesDataList />
                    <Box pt={3}>
                    </Box>
                </CenteredCard>
            </Container>
        )
    }
}

export default Games;
