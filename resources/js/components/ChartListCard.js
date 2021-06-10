import { Box, Card, CardActions, CardContent, CardHeader, Typography, Button, ListItem, ListItemIcon, List, ListItemText } from '@material-ui/core';
import { AccountCircle, Hotel, VerifiedUser } from '@material-ui/icons';
import React from 'react';
import { Link } from 'react-router-dom';

class ChartListCard extends React.Component {

    constructor(props) {
        super(props);
    }

    getDate(date) {
        let parsed_date = new Date(date);
        return parsed_date.toLocaleDateString('it-IT', { month: '2-digit', year: 'numeric', day: '2-digit' });
    }

    render() {
        return(
            <Card elevation={5} >
                <CardHeader
                    avatar={ <AccountCircle /> }
                    title={ ( <span> { this.props.p.name } { this.props.p.user && <VerifiedUser style={{ fontSize: 15 }} /> } </span> ) }
                    subheader={ "Iscritto dal " + this.getDate(this.props.p.created_at) } />
                <CardContent>
                    { this.props.p.user && this.props.p.user.slogan && (
                        <Typography variant="h6"> {this.props.p.user.slogan} </Typography>

                    )}
                    { this.props.p.user && this.props.p.user.bio && (
                        <Typography variant="body2" color="textSecondary"> {this.props.p.user.bio} </Typography>

                    )}
                    <List dense>
                        <ListItem>
                            <ListItemText
                                primary="Attacco"
                                secondary={ "Su " + ( this.props.p.asAtt1 + this.props.p.asAtt2 ) + " partite (" + ( this.props.p.asAtt1R + this.props.p.asAtt2R ) + " recenti)"} />
                            <ListItemIcon>
                                {this.props.p.apoints}
                            </ListItemIcon>
                        </ListItem>
                        <ListItem>
                            <ListItemText
                                primary="Difesa"
                                secondary={ "Su " + ( this.props.p.asDif1 + this.props.p.asDif2 ) + " partite (" + ( this.props.p.asDif1R + this.props.p.asDif2R ) + " recenti)"} />
                            <ListItemIcon>
                                {this.props.p.dpoints}
                            </ListItemIcon>
                        </ListItem>
                        <ListItem>
                            <ListItemText
                                primary="Totale"
                                secondary={ "Su " + ( this.props.p.asAtt1 + this.props.p.asAtt2 + this.props.p.asDif1 + this.props.p.asDif2 ) + " partite (" + ( this.props.p.asAtt1R + this.props.p.asAtt2R + this.props.p.asDif1R + this.props.p.asDif2R ) + " recenti)"} />
                            <ListItemIcon>
                                { (this.props.p.apoints + this.props.p.dpoints) / 2. }
                            </ListItemIcon>
                        </ListItem>
                    </List>
                </CardContent>
                <CardActions style={{justifyContent: 'center'}} >
                    <Button variant="outlined" component={ Link } to={ "/player/" + this.props.p.id}>
                        More
                    </Button>
                </CardActions>
            </Card>
        )
    }
}

export default ChartListCard;
