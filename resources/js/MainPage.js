import { Backdrop, CircularProgress, CssBaseline } from '@material-ui/core';
import { ThemeProvider } from '@material-ui/styles';
import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter, Route, Switch, IndexRoute, NavLink, Redirect } from 'react-router-dom';
import Example from './components/Example';
import TopBar from './navigation/TopBar';
import AddGame from './pages/AddGame';
import Association from './pages/Association';
import Chart from './pages/Chart';
import Games from './pages/Games';
import SignIn from './pages/SignIn';
import theme from './theme';

class MainPage extends Component {

    constructor(props) {
        super(props);
        this.state = {
            user: undefined,
            loading: 0,
            params: undefined,
            players: [],
            games: []
        }
    }

    componentDidMount() {
        this.loadParams();
        this.refreshChart();
    }

    refreshChart() {
        this.loadUser();
        this.loadPlayers();
        this.loadGames();
    }

    async loadUser() {
        this.setState( { loading: this.state.loading+1 } );
        let u = await $.get( base_url + '/api/user/me' )
        this.setState( { user: u.data, loading: this.state.loading-1 } );
    }

    async loadGames() {
        this.setState( { loading: this.state.loading+1 } );
        let u = await $.get( base_url + '/api/game/all' );
        this.setState( { games: u.data, loading: this.state.loading-1 } );
    }

    async loadParams() {
        this.setState( { loading: this.state.loading+1 } );
        let u = await $.get( base_url + '/api/param/all' );
        let params = {};
        u.forEach( item => params[ item.key ] = ( isNaN(item.value) ? item.value : parseFloat(item.value) ) );
        this.setState( { params: params, loading: this.state.loading-1 } );
    }
    
    async loadPlayers() {
        this.setState( { loading: this.state.loading+1 } );
        let u = await $.get( base_url + '/api/player/all' );
        this.setState( { players: u, loading: this.state.loading-1 } );
    }

    main_routing() {
        return (
            <Switch>
                <Route path="/login" component={Redirect} to="/auth/login_google" />
                <Route path="/chart">
                    <Chart players={ this.state.players } logged={ this.state.user !== undefined }/>
                </Route>
                <Route path="/games">
                    <Games games={ this.state.games }/>
                </Route>
                <Route path="/sign-in">
                    <SignIn onDone={ this.refreshChart.bind(this) } />
                </Route>
                <Route path="/add-game">
                    <AddGame players={ this.state.players } onDone={ this.refreshChart.bind(this) } />
                </Route> {/* todo protect to logged users */}
                <Redirect from="*" to="/chart" />
            </Switch>
        )
    }

    force_association() {
        return(
            <Switch>
                <Route path="/associate">
                    <Association onDone={ this.refreshChart.bind(this) } />
                </Route>
                <Route path="/sign-in">
                    <SignIn onDone={ this.refreshChart.bind(this) } />
                </Route>
                <Redirect from="*" to="/associate" />
            </Switch>
        )
    }

    render() {
        var base_path = base_url.replace( /[^/:]*:\/\/[^/]*\//, '');
        return(
            <ThemeProvider theme={theme}>
            <BrowserRouter basename={base_path} >
                <CssBaseline />
                <TopBar basePath = {base_path} user = {this.state.user} />
                {/* If the user is logged but no register, redirect to association page */}
                { ( this.state.user && !(this.state.user.name) ) ?
                    this.force_association() :
                    this.main_routing()
                }
                <Backdrop style={{ zIndex: 1500 }} open={ this.state.loading > 0 }>
                    <CircularProgress />
                </Backdrop>
            </BrowserRouter>
            </ThemeProvider>
        );

    }
}

if (document.getElementById('thecontent')) {
    ReactDOM.render(<MainPage />, document.getElementById('thecontent'));
}