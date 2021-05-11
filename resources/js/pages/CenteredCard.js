import { Box, Card, CardContent, CardHeader, Container, Grid } from '@material-ui/core';
import React from 'react';

class CenteredCard extends React.Component {

    constructor(props) {
        super(props);
    }

    render() {
        return(
            <Container>
                <Box py={3} my={3}>
                    <Grid container justify="center">
                        <Grid item xs={12} sm={6} component={Card} variant="outlined">
                            <CardHeader
                                title={this.props.title}
                                subheader={this.props.subtitle}
                                />
                            <CardContent>
                                {this.props.children}
                            </CardContent>
                        </Grid>
                    </Grid>
                </Box>
            </Container>
        )
    }
}

export default CenteredCard;
