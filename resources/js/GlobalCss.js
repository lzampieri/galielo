import { withStyles } from "@material-ui/styles";

const GlobalCss = withStyles({
    '@global': {
      'a': {
        color: 'inherit',
      },
    },
})(() => null);

export default GlobalCss;