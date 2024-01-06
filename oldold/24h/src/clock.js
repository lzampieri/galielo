import { Typography } from "@mui/material";
import { PureComponent } from "react";

const zeroPad = (num) => String(num).padStart(2, '0')

class Clock extends PureComponent {

    constructor(props) {
        super(props);
        this.state = {
            time: this.getTime(),
            interval: setInterval( () => this.setState({time: this.getTime()}), 500 )
        }
    }

    componentWillUnmount() {
        clearInterval( this.state.interval );
    }

    getTime() {
        let date = new Date();
        return zeroPad(date.getHours()) + ":" + zeroPad(date.getMinutes()) + ":" + zeroPad(date.getSeconds());
    }

    render() {
        return <Typography variant='h3' sx={{ padding: 3 }}>
            { this.state.time }
        </Typography>
    }
}

export default Clock;