import { Backdrop, Box, Button, CircularProgress, List, ListItem, ListItemIcon } from '@material-ui/core';
import { AccountCircle } from '@material-ui/icons';
import React from 'react';
import { Redirect } from 'react-router';
import { Link } from 'react-router-dom';

class UserSelectForm extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            isLoading: true,
            redirectHome: false,
            errorMessage: undefined,
            players: []
        }
    }

    async componentDidMount() {
        let players = await $.get( base_url + '/api/player/unassociated' );
        this.setState( { players: players, isLoading: false } );
    }

    async save(id) {
        this.setState( { isLoading: true } );
        let result = await $.post( base_url + '/api/player/associate', {
            player_id: id,
            _token: csrfmiddlewaretoken
        } );
        if( result.success ) {
            this.props.onDone();
            this.setState({ redirectHome: true });
        } else {
            this.setState({ errorMessage: result.errorInfo[2] });
        }
    }

    listitem(p) {
        return (
            <ListItem
                button variant="outlined"
                key={p.id}
                onClick={ this.save.bind(this, p.id) }
                >
                <ListItemIcon>
                    <AccountCircle />
                </ListItemIcon>
                { p.name }
            </ListItem>
        )
    }

    render() {
        return(
            <Box display="flex" flexDirection="column" justify="center" alignItems="center">
                { this.state.errorMessage && (<Alert severity="error">{this.state.errorMessage}</Alert>) }
                <List>
                    { this.state.players.map( p => this.listitem(p) ) }
                </List>
                <Button
                    variant="outlined"
                    disabled={this.state.isLoading}
                    component={Link}
                    to="/sign-in"
                > Non sono ancora registrato </Button>
                { this.state.redirectHome ? (
                        <Redirect to="/" />
                    ) : "" }
                <Backdrop open={this.state.isLoading} style={{ zIndex: 1500 }}>
                    <CircularProgress color="inherit" />
                </Backdrop>
            </Box>
        )
    }
}

export default UserSelectForm;
