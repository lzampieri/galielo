import { Grid, Card, CardHeader, CardContent, Typography  } from '@material-ui/core';
import { Trophy } from 'mdi-material-ui';
import React from 'react';

class CupCard extends React.Component {

    constructor(props) {
        super(props);
    }

    render() {
        return(
            <Grid item xs={12} sm={this.props.sm||6} >
            <Card variant="outlined" elevation={5}>
                <CardHeader
                    avatar={ <Trophy /> }
                    title={ this.props.title }
                    subheader={ this.props.details } />
                <CardContent>
                    <Typography variant="h4">
                        { this.props.children }
                    </Typography>
                </CardContent>
            </Card>
            </Grid>
        )
    }
}

export default CupCard;
