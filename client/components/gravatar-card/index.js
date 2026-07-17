import React from 'react';
import GravatarSkeleton from './skeleton';
import './style.scss'
 
export default function GravatarCard( { gravatarData, hasError, isLoading } ) {
    if ( hasError ) {
        return (
            <div className="gravatar-card__error">
                Gravatar profile not found!
            </div>
        )
    }
 
    if ( isLoading ) {
    return <GravatarSkeleton />
    }
 
    if ( ! gravatarData ) {
        return null;
    }
 
    return (
        <div className="gravatar-card">
            <img src={ gravatarData.avatar_url + '?size=256' } className="gravatar-card__avatar" />
            <h1 className="gravatar-card__name">{ gravatarData.display_name }</h1>
            <div className="gravatar-card__meta">
                <div>
                    { gravatarData.job_title && (
                        <span>
                            { gravatarData.job_title }
                            { gravatarData.company && ( ', ' ) }
                        </span>
                    ) }
                    { gravatarData.company && (
                        <span>{ gravatarData.company }</span>
                    ) }
                </div>
                <div className="gravatar-card__meta-personal">
                    { gravatarData.pronunciation && (
                        <>
                            <span>{ gravatarData.pronunciation }</span>
                            { gravatarData.pronouns && ( <span>·</span> ) }
                        </>
                    ) }
                    { gravatarData.pronouns && (
                        <>
                            <span>{ gravatarData.pronouns }</span>
                            { gravatarData.location && ( <span>·</span> ) }
                        </>
                    ) }
                    { gravatarData.location && (
                        <span>{ gravatarData.location }</span>
                    ) }
                </div>
            </div>
            <p className="gravatar-card__description">{ gravatarData.description }</p>
            <div className="gravatar-card__network">
                <>
                    <a href={ gravatarData.profile_url }>
                        <img src="https://secure.gravatar.com/icons/gravatar.svg" />
                    </a>
                    { gravatarData.verified_accounts.slice( 0, 3 ).map( acc =>
                        <a key={ acc.service_label } href={ acc.url }>
                            <img src={ acc.service_icon } alt={ acc.service_label } />
                        </a>
                    ) }
                </>
            </div>
        </div>
    )
}
