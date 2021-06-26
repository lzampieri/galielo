import React from 'react';
import useMediaQuery from '@material-ui/core/useMediaQuery';

const withMediaQuery = (...args) => Component => props => {
  const mediaQuery = useMediaQuery(...args);
  return <Component mediaQuery={mediaQuery} {...props} />;
};

export default withMediaQuery;