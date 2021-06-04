import { Backdrop, Box, CircularProgress, Typography } from '@material-ui/core';
import React from 'react';

const sentences = [
    "Verificando se era gancio...",
    "Installando la smart camera...",
    "Calcolando l'angolo della mezzaluna...",
    "Cercando un moralista bravo...",
    "Oliando le stecche...",
    "Passando sotto...",
    "Cercando il quarto..."
];
const updateTime = 3000;

class MyBackDrop extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            sentenceId: 0
        }
    }

    componentDidMount() {
        this.updateSentence();
        this.setState({
            intervalId: setInterval( this.updateSentence.bind(this), updateTime ),
            sentenceId: Math.floor(Math.random() * sentences.length )
        });
    }

    componentDidUpdate(prevProps) {
        if( Boolean(this.props.open) && !Boolean(prevProps.open) )
            this.setState({ intervalId: setInterval( this.updateSentence.bind(this), updateTime ) });
        if( !Boolean(this.props.open) && Boolean(prevProps.open) )
            clearInterval( this.state.intervalId );
    }

    updateSentence() {
        this.setState({ sentenceId: ( this.state.sentenceId + 1 ) % sentences.length });
    }

    render() {
        return(
            <Backdrop style={{ zIndex: 1500 }} open={ Boolean(this.props.open) }>
            <Box display="flex" flexDirection="column" justify="center" alignItems="center">
                <CircularProgress />
                <Typography variant="h5">
                    { sentences[ this.state.sentenceId ] }
                </Typography>
            </Box>
            </Backdrop>
        )
    }
}

export default MyBackDrop;
