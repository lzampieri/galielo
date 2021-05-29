import { createMuiTheme } from "@material-ui/core";
import { itIT } from '@material-ui/data-grid';

const theme = createMuiTheme({
    palette: {
        type: 'dark',
        primary: {
            main: '#a42c34'
        },
        secondary: {
            main: '#2c54bc'
        },
    }
});

export default theme;