import { Backdrop, Box, Button, CircularProgress } from '@material-ui/core';
import { Alert } from '@material-ui/lab';
import { Field, Form, Formik } from 'formik';
import { TextField } from 'formik-material-ui';
import React from 'react';
import { Redirect } from 'react-router';

class SignInForm extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            redirectHome: false
        }
    }

    validator(values) {
        const errors= {};
        if ( !values.name || values.name.length < 5 ) {
            errors.name = 'Inserisci un nome valido.';
        } else if( values.name.length > 50 ) {
            errors.name = 'Nome troppo lungo.'
        }
        return errors;
    }

    async save(values, setStatus) {
        let result = await $.post( base_url + '/api/player', values );
        if( result.success ) {
            this.props.onDone();
            this.setState({ redirectHome: true });
        } else {
            setStatus({ error: result.errorInfo[2] });
        }
    }

    render() {
        return(
            <Formik
                initialValues = { {
                    name: "",
                    _token: csrfmiddlewaretoken
                } }
                validate = { values => this.validator(values) }
                onSubmit = { (values, {setStatus}) => this.save(values, setStatus) }
            >
                { ({submitForm, isSubmitting, status, errors}) => (
                <Form style={{ width: "100%" }} >
                    <Box display="flex" flexDirection="column" justify="center" alignItems="center">
                        { status && (<Alert severity="error">{status.error}</Alert>) }
                        <Field
                            component={TextField}
                            name="name"
                            label="Nome e cognome"
                            style={{ width: "100%"}}
                        />
                        <Field
                            name="_token"
                            hidden
                            />
                        <br/>
                        <Button
                            variant="outlined"
                            disabled={isSubmitting}
                            onClick={submitForm}
                        > Registrati! </Button>
                    </Box>
                    <Backdrop open={isSubmitting} style={{ zIndex: 1500 }}>
                        <CircularProgress color="inherit" />
                    </Backdrop>
                    { this.state.redirectHome ? (
                        <Redirect to="/force-refresh-user" />
                    ) : "" }
                </Form>
                )}
            </Formik>
        )
    }
}

export default SignInForm;
