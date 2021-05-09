import { Box, Container, Grid, Typography, Button } from '@material-ui/core';
import React from 'react';
import { Link } from 'react-router-dom';
import SignInForm from '../components/SignInForm';

class SignIn extends React.Component {

    constructor(props) {
        super(props);
    }

    render() {
        const { classes } = this.props;
        return(
            <Container>
                <Box py={3}>
                    <Grid container justify="center">
                        <Grid item xs={12} sm={6}>
                            <SignInForm />
                        </Grid>
                    </Grid>
                </Box>
            </Container>
        )
    }
}

export default SignIn;
