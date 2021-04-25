import { AppBar, Button, Drawer, IconButton, makeStyles, Toolbar, Typography, withStyles, List, ListItem, ListItemText } from '@material-ui/core';
import MenuIcon from '@material-ui/icons/Menu';
import React from 'react';
import { withRouter } from 'react-router';
import { Link } from 'react-router-dom';
import theme from '../theme';

const styles = {
    title: {
        flexGrow: 1
    },
    onlymobile: {
        [theme.breakpoints.up('sm')]: {
            display: 'none'
        }
    },
    notformobile: {
        display: 'none',
        [theme.breakpoints.up('sm')]: {
            display: 'block'
        }
    }
};

class TopBar extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            drawerOpen: false
        }
        this.links = [
            [ 'Classifica', 'chart'],
            [ 'Partite', 'match'],
            [ 'Ccup', 'ccup'],
            [ 'Tweets', 'tweets'],
            [ 'Login', 'login']
        ]
    }

    componentDidMount() {
    }

    openDrawer () {
        this.setState( { drawerOpen: true } );
    }

    closeDrawer () {
        this.setState( { drawerOpen: false } );
    }

    isActive( url ) {
        return this.props.location.pathname.search( url ) >= 0;
    }

    getFullUrl( url ) {
        return '/' + this.props.basePath + '/' + url;
    }

    getItems ( mobile = false ) {
        return this.links.map( item => { return ( mobile ? (
                <ListItem
                    button
                    to={ item[1] }
                    key={ item[0] }
                    component={ Link }
                    selected={ this.isActive(item[1]) } >
                    <ListItemText primary={ item[0] } />
                </ListItem>
            ) : (
                <Button
                    to={ item[1] }
                    key={ item[0] }
                    component={ Link }
                    variant={ this.isActive(item[1]) ? 'contained' : 'text' } >
                    { item[0] }
                </Button>
            ) ) }
        );
    } 

    render() {
        const { classes } = this.props;
        return (
            <header>
                <AppBar position="static">
                    <Toolbar>
                        <Typography variant="h6" className={classes.title} >
                            GaliElo
                        </Typography>
                        <div className={classes.notformobile}>
                            { this.getItems() }
                        </div>
                        <IconButton edge="start" aria-label="menu" onClick={ this.openDrawer.bind(this) } className={classes.onlymobile}>
                            <MenuIcon />
                        </IconButton>
                        <Drawer
                            anchor="right"
                            open={ this.state.drawerOpen }
                            onClose={ this.closeDrawer.bind(this) } >
                            <List style={ {width: 250} }>
                                { this.getItems( true ) }
                            </List>
                        </Drawer>
                    </Toolbar>
                </AppBar>
            </header>
        );
    }
    
}

export default withRouter(withStyles(styles)(TopBar));
