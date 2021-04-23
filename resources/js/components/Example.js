import React from 'react';
import ReactDOM from 'react-dom';
import TopBar from '../navigation/TopBar';

function Example() {
    return (
        <div>
            <TopBar />
            <div className="container">
                <div className="row justify-content-center">
                    <div className="col-md-8">
                        <div className="card">
                            <div className="card-header">Example Component</div>
                            <div className="card-body">I'm an example component!</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default Example;

if (document.getElementById('thecontent')) {
    ReactDOM.render(<Example />, document.getElementById('thecontent'));
}
