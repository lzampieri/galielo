import { Button, Container, Grid, Stack, Typography } from "@mui/material";
import { Component } from "react";
import Clock from './clock';
import TeamPaper from './teamPaper';
import $ from 'jquery';
import DetailedData from "./detailedData";


class MainComponent extends Component {

    constructor(props) {
        super(props);
        this.state = {
            team1: 0,
            team2: 0,
            success: false,
            interval: -1,
            team_show: false,
            teams: {}
        }
    }

    async componentDidMount() {
        this.updateData();
        let teams = await $.get( process.env.PUBLIC_URL + '/teams.json' );
        this.setState({ teams: teams });
    }

    componentWillUnmount() {
        clearInterval( this.state.interval );
    }

    async updateData() {
        let data = await $.get( process.env.REACT_APP_API_URL + "get" );
        let new_state = JSON.parse(data);
        if( !new_state.success ) new_state.success = false;
        this.setState( new_state );
        if( this.state.interval === -1 )
            this.setState({ interval: setInterval( () => this.updateData(), 5000 ) });
    }

    render() {
        return (
            <Container sx={{ 
                minHeight: "100vh",
                display: "flex",
                flexDirection: "column",
                justifyContent: "center",
                alignItems: "center"
            }}>
                <Clock />
                <Grid container spacing={3}>
                    <Grid item xs={6}>
                    <TeamPaper
                        teamId={0}
                        points={this.state.team0}
                        members={this.state.teams.team0}
                        displayTeams={this.state.team_show}
                        update={ this.updateData.bind(this) }/>
                    </Grid> 
                    <Grid item xs={6}>
                    <TeamPaper
                        teamId={1}
                        points={this.state.team1}
                        members={this.state.teams.team1}
                        displayTeams={this.state.team_show}
                        update={ this.updateData.bind(this) }/>
                    </Grid>
                </Grid>
                <Typography variant="body2">Stato server: 
                    { this.state.success ?
                        <Typography sx={{color: "green"}} component="span"> online</Typography>
                        :
                        <Typography sx={{color: "red"}} component="span"> offline</Typography>
                        }
                </Typography>
                <Stack direction="row" spacing={2}>
                    <Button component="a" href="https://youtube.com/channel/UCBd2eriB0ctCHz-blV1fe4w" variant="outlined">Diretta streaming</Button>
                    <Button onClick={() => this.setState({ team_show: !this.state.team_show })} variant="outlined">Mostra squadre</Button>
                </Stack>
                <DetailedData />
            </Container>
        );
    }
}

export default MainComponent;