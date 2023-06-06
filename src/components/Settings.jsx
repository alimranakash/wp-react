import React, { useState, useEffect } from 'react';
import axios from 'axios';

const Settings = () => {

    const [ firstname, setFirstName ] = useState( '' );
    const [ lastname, setLastName ] = useState( '' );
    const [ email, setEmail ] = useState( '' );
    const [ loader, setLoader ] = useState( 'Save Settings' );

    const url = `${wpreact.apiUrl}/wpreact/v1/settings`;
    
    const handleSubmit = (e) => {
        e.preventDefault();

        setLoader( 'Saving...' );

        axios.post( url, {
            firstname: firstname,
            lastname: lastname,
            email: email
        }, {
            headers: {
                'content-type': 'application/json',
                'X-WP-NONCE': wpreact.nonce
            }
        })
        .then( (response) => {
            setLoader( 'Save Settings' );
            console.log(response);
        })
    }

    useEffect( () => {
        axios.get( url )
          .then( (response) => {
            setFirstName( response.data.firstname );
            setLastName( response.data.lastname );
            setEmail( response.data.email );
            
            console.log(response);
        })
    }, [] )

    return(
        <React.Fragment>
            <h2>Settings</h2>

            <form id="wpreact-settings-form" onSubmit={ (e) => handleSubmit(e) }>
                <p>
                    <label htmlFor="">First Name</label>
                    <input type="text" name="firstname" value={ firstname } onChange={ (e) => { setFirstName( e.target.value ) } } />
                </p>
                <p>
                    <label htmlFor="">Last Name</label>
                    <input type="text" name="lastname" value={ lastname } onChange={ (e) => { setLastName( e.target.value ) } } />
                </p>
                <p>
                    <label htmlFor="">Email</label>
                    <input type="email" name="email" value={ email } onChange={ (e) => { setEmail( e.target.value ) } } />
                </p>
                <p>
                    <button type="submit">{loader}</button>
                </p>
            </form>
        </React.Fragment>
    )
}
export default Settings;