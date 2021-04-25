import { CssBaseline } from '@material-ui/core';
import { ThemeProvider } from '@material-ui/styles';
import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter, Route, Switch } from 'react-router-dom';
import Example from './components/Example';
import TopBar from './navigation/topbar';
import theme from './theme';

function MainPage() {
    var base_path = base_url.replace( /[^/:]*:\/\/[^/]*\//, '');
    return(
        <ThemeProvider theme={theme}>
            <CssBaseline />
            <TopBar/>
            <BrowserRouter basename={base_path}>
                <Switch>
                    <Route path="/:thepar" component={Example} />
                </Switch>
            </BrowserRouter>
        </ThemeProvider>
    );
}

if (document.getElementById('thecontent')) {
    ReactDOM.render(<MainPage />, document.getElementById('thecontent'));
}