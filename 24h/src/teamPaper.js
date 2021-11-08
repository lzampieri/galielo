import { Button, CircularProgress, Dialog, DialogActions, DialogContent, DialogTitle, Paper, Stack, Typography } from "@mui/material";
import { Component } from "react";
import $ from 'jquery';
import { withSnackbar } from "notistack";

const bgcolors = ['primary.main', 'primary.main'];
const colors = ['#BAA22B', '#A31EEB'];
const names = ['e', 'π'];

class TeamPaper extends Component {

    constructor(props) {
        super(props);
        this.state = {
            dialog_open: false,
            loading: false
        }
    }

    async sendGoal() {
        this.setState({ loading: true });
        let data = await $.get( process.env.REACT_APP_API_URL + "add=" + this.props.teamId );
        if( JSON.parse( data ).success ) {
            this.props.enqueueSnackbar('Gol salvato', {variant: 'success'});
        } else {
            this.props.enqueueSnackbar('Errore non identificato', {variant: 'error'});
        }
        
        await this.props.update();

        this.setState({ loading: false, dialog_open: false });
    }

    render() {
        return (
            <Paper elevation={3} sx={{ padding: 3 }} >
                <Stack alignItems='center'>
                    <Paper elevation={3} sx={{
                        padding: 3,
                        backgroundColor: bgcolors[this.props.teamId],
                        color: colors[this.props.teamId] }}>
                        <Typography variant="h2" sx={{ fontWeight: 600 }} >
                            {names[this.props.teamId]}
                        </Typography>
                    </Paper>
                    <Typography variant="h2" sx={{
                        padding: 3,
                        fontWeight: 600,
                        color: bgcolors[this.props.teamId] }} >
                        { this.props.points || "0" }
                    </Typography>
                    <Button variant="outlined" sx={{ color: colors[this.props.teamId] }} onClick={ () => this.setState({ dialog_open: true })}>
                        Gol!
                    </Button>
                    <Dialog
                        open={ this.state.dialog_open || this.state.loading }
                        onClose={ () => this.setState({ dialog_open: false }) }
                    >
                        <DialogTitle>
                            {"Confermi?"}
                        </DialogTitle>
                        <DialogContent>
                            Vuoi confermare un Gol per la squadra {names[this.props.teamId]}?
                        </DialogContent>
                        <DialogActions>
                            <CircularProgress sx={{ display: this.state.loading ? 'block' : 'none' }} />
                            <Button onClick={ () => this.setState({ dialog_open: false }) } disabled={ this.state.loading }>Annullo</Button>
                            <Button onClick={ () => this.sendGoal() } disabled={ this.state.loading } autoFocus>Confermo</Button>
                        </DialogActions>
                    </Dialog>
                </Stack>
            </Paper>
        )
    }
}

export default withSnackbar(TeamPaper);