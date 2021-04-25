import { CssBaseline } from '@material-ui/core';
import { ThemeProvider } from '@material-ui/styles';
import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter, Route, Switch, IndexRoute, NavLink } from 'react-router-dom';
import Example from './components/Example';
import TopBar from './navigation/TopBar';
import theme from './theme';

function MainPage() {
    var base_path = base_url.replace( /[^/:]*:\/\/[^/]*\//, '');
    return(
        <ThemeProvider theme={theme}>
        <BrowserRouter basename={base_path} >
            <CssBaseline />
            <TopBar basePath = {base_path} />
            <Switch>
                <Route path="/" component={Example} />
                <Route path="/:thepar" component={Example} />
            </Switch>
        </BrowserRouter>
        </ThemeProvider>
    );
}

if (document.getElementById('thecontent')) {
    ReactDOM.render(<MainPage />, document.getElementById('thecontent'));
}