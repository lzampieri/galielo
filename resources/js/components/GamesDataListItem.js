import { Grid, ListItem, Typography, ListItemText } from '@material-ui/core';
import { AccountCircle } from '@material-ui/icons';
import { Skeleton } from '@material-ui/lab';
import { withStyles } from '@material-ui/styles';
import React from 'react';
import ParamsContext from '../ParamsContext';

const styles = (theme) => { return {
    main: {
        borderWidth: 0,
        borderBottomWidth: 1,
        borderColor: theme.palette.divider,
        borderStyle: 'solid',
        height: '100%'
    },
    left: {
        textAlign: 'right',
        [theme.breakpoints.down('sm')]: {
            textAlign: 'center'
        }
    },
    center: {
        textAlign: 'center'
    },
    right: {
        textAlign: 'left',
        [theme.breakpoints.down('sm')]: {
            textAlign: 'center'
        }
    }
}}

class GamesDataListItem extends React.Component {

    constructor(props) {
        super(props);
    }
    
    getDate(date) {
        let parsed_date = new Date(date);
        return parsed_date.toLocaleDateString('it-IT', { month: '2-digit', year: 'numeric', day: '2-digit' });
    }

    render() {
        const { classes } = this.props;
        if( !this.props.game )
        return( <ListItem style={ this.props.upstyle }>
            <Skeleton variant="rect" width="100%" height={40} />
        </ListItem>)
        return(
                <ListItem style={ this.props.upstyle }>
                    <Grid container spacing={0} className={ classes.main }>
                        <Grid item xs={12} md={4} className={ classes.left }>
                            { this.props.game.att1 } (+{ this.props.game.deltaa1 }) <br/>
                            { this.props.game.dif1 } (+{ this.props.game.deltad1 }) 
                        </Grid>
                        <Grid item xs={3} md={1}  className={ classes.center }>
                            <Typography variant="h4">
                                { this.props.game.pt1 }
                            </Typography>
                        </Grid>
                        <Grid item xs={6} md={2}  className={ classes.center }>
                            { this.getDate(this.props.game.date) } <br/>
                            { this.props.game.table }
                        </Grid>
                        <Grid item xs={3} md={1}  className={ classes.center }>
                            <Typography variant="h4">
                                { this.props.game.pt2 }
                            </Typography>
                        </Grid>
                        <Grid item xs={12} md={4}  className={ classes.right }>
                            { this.props.game.att2 } ({ this.props.game.deltaa2 }) <br/>
                            { this.props.game.dif2 } ({ this.props.game.deltad2 }) 
                        </Grid>
                    </Grid>
                </ListItem>
        )
    }
}

GamesDataListItem.contextType = ParamsContext;

export default withStyles(styles)(GamesDataListItem);
