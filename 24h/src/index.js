import { CssBaseline, ThemeProvider } from '@mui/material';
import React from 'react';
import ReactDOM from 'react-dom';
import MainComponent from './mainComponent';
import {SnackbarProvider} from 'notistack';

import theme from './theme';

ReactDOM.render(
    <React.StrictMode>
        <ThemeProvider theme={ theme }>
            <CssBaseline/>
            <SnackbarProvider>
              <MainComponent />
            </SnackbarProvider>
        </ThemeProvider>
    </React.StrictMode>,
    document.getElementById('root')
);