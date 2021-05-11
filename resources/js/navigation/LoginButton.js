import { AppBar, Button, Drawer, IconButton, makeStyles, Toolbar, Typography, withStyles, List, ListItem, ListItemText, Menu, MenuItem } from '@material-ui/core';
import { AccountCircle } from '@material-ui/icons';
import MenuIcon from '@material-ui/icons/Menu';
import React from 'react';
import { withRouter } from 'react-router';
import { Link } from 'react-router-dom';
import theme from '../theme';

class LoginButton extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            menuOpen: false,
            anchorEl: undefined
        }
    }

    switchMenu( event ) {
        this.setState( { menuOpen: !this.state.menuOpen, anchorEl: event.currentTarget } );
    }

    menu() {
        return (
            <Menu
                anchorEl={ this.state.anchorEl }
                open={ this.state.menuOpen }
                onClose={ this.switchMenu.bind(this) }
                >
                <MenuItem 
                    button
                    component= {Link}
                    onClick={ this.switchMenu.bind(this) }
                    to= {"profile"} >
                    Profilo
                </MenuItem>
                <MenuItem
                    button
                    component= 'a'
                    onClick={ this.switchMenu.bind(this) }
                    href= { base_url + '/auth/logout_google' }
                    >
                    Logout
                </MenuItem>
            </Menu>
        )
    }

    render() {
        if( this.props.user ) return (
            this.props.mobile ? (
                <span>
                    <ListItem
                        button
                        onClick={ this.switchMenu.bind(this) }
                        key={ "login" } >
                        <ListItemText primary={ this.props.user.email } />
                    </ListItem>
                    { this.menu() }
                </span>
            ) : (
                <span>
                    <Button
                        onClick={ this.switchMenu.bind(this) }
                        key={ "login" }
                        >
                        <AccountCircle />
                    </Button>
                    { this.menu() }
                </span>
            ) )
        else return (
            this.props.mobile ? (
                <ListItem
                    button
                    href={ base_url + "/auth/login_google" }

                    key={ "login" } >
                    <ListItemText primary={ "Login" } />
                </ListItem>
            ) : (
                <Button
                    href={ base_url + "/auth/login_google" }
                    key={ "login" } >
                    { "Login" }
                </Button>
            )
        )
    }
    
}

export default (LoginButton);
