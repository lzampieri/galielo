import { AppBar, Button, Drawer, IconButton, makeStyles, Toolbar, Typography, withStyles, List, ListItem, ListItemText } from '@material-ui/core';
import MenuIcon from '@material-ui/icons/Menu';
import React from 'react';
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
            [ 'Classifica', 'url'],
            [ 'Partite', 'url'],
            [ 'Ccup', 'url'],
            [ 'Tweets', 'url'],
            [ 'Login', 'url']
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

    getItems ( mobile = false ) {
        if( mobile )
            return this.links.map( item => (
                <ListItem button component="a" key={ item[0] } href={ item[1] }>
                    <ListItemText primary={ item[0] } />
                </ListItem>
            ));
        else return this.links.map( item => (
            <Button href={ item[1] } key={ item[0] }>{ item[0] }</Button>
        ));
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

export default withStyles(styles)(TopBar);
