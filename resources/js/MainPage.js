import { Backdrop, CircularProgress, CssBaseline } from '@material-ui/core';
import { ThemeProvider } from '@material-ui/styles';
import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter, Route, Switch, IndexRoute, NavLink, Redirect } from 'react-router-dom';
import Example from './components/Example';
import TopBar from './navigation/TopBar';
import Chart from './pages/Chart';
import theme from './theme';

class MainPage extends Component {

    constructor(props) {
        super(props);
        this.state = {
            user: undefined,
            loading: true
        }
    }

    async componentDidMount() {
        let u = await $.get( base_url + '/api/user/me' )
        this.setState( { user: ( u.data ? u.data.email : undefined ), loading: false } );
    }

    render() {
        var base_path = base_url.replace( /[^/:]*:\/\/[^/]*\//, '');
        return(
            <ThemeProvider theme={theme}>
            <BrowserRouter basename={base_path} >
                <CssBaseline />
                <TopBar basePath = {base_path} user = {this.state.user} />
                <Switch>
                    <Route path="/login" component={Redirect} to="/auth/login_google" />
                    <Route path="/chart" component={Chart} />
                    <Route exact path="/"><Redirect to="/chart" /></Route>
                </Switch>
                <Backdrop style={{ zIndex: 1500 }} open={ this.state.loading }>
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