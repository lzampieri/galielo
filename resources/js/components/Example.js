import React from 'react';
import { withRouter } from 'react-router';

class Example extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            location: props.match.params.thepar
        }
    }

    render() {
        return(
            <div className="container">
                <div className="row justify-content-center">
                    <div className="col-md-8">
                        <div className="card">
                            <div className="card-header">Example Component</div>
                            <div className="card-body">{ this.state.location }</div>
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}

export default withRouter(Example);
