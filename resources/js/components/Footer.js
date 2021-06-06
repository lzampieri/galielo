import { Box } from "@material-ui/core";
import React from "react";
import { Link } from "react-router-dom";

class Footer extends React.Component {

    constructor(props) {
        super(props);
    }

    render() {
        return(
            <Box
                display="flex"
                flexDirection="row" 
                justifyContent="center">
                <Link
                    to="about">
                    About
                </Link>
            </Box>
        )
    }
}

export default Footer;
