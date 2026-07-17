import React from 'react';
import { createRoot } from 'react-dom/client';
import GravatarLoader from "./components/gravatar-loader";
import './style.scss';
 
const App = () => (
    <div className="gravatar-example">
        <h1>Hello, Gravatar!</h1>
        <GravatarLoader />
    </div>
);
 
const container = document.getElementById( 'root' );
const root = createRoot( container );
root.render( <App /> );
