import React from 'react';
import ParamsContext from '../ParamsContext';
import GamesDataListItem from './GamesDataListItem';
import { FixedSizeList } from 'react-window';
import InfiniteLoader from 'react-window-infinite-loader';
import { useMediaQuery, useTheme } from '@material-ui/core';
import withMediaQuery from './withMediaQuery';

const mediaQuery = theme => theme.breakpoints.down('sm');

class GamesDataList extends React.PureComponent {

    constructor(props) {
        super(props);
        this.state = {
            totalRowCount: 1000,
            games: []
        }
        this.lastPageLoaded= 0;
        this.loading= false;
    }

    componentDidMount() {
    }

    loadMoreItems(startIndex,stopIndex) {
        return new Promise(
            () => this.downloadPagesUntil(stopIndex)
        );
    }

    async downloadPagesUntil(finalIndex) {
        while( finalIndex >= this.state.games.length )
            await this.downloadPage();
    }

    async downloadPage() {
        let res = await $.get( base_url + '/api/game/some?page=' + ( this.lastPageLoaded + 1 ) );
        this.setState({
            totalRowCount: res.meta.total,
            games: this.state.games.concat( res.data )
        })
        this.lastPageLoaded += 1;
    }

    render() {
        const mobile = this.props.mediaQuery;
        return(
            <InfiniteLoader
                isItemLoaded={ index => ( index < this.state.games.length ) }
                itemCount={ this.state.totalRowCount }
                loadMoreItems={ this.loadMoreItems.bind(this) }
                >
                {({ onItemsRendered, ref }) => (
                    <FixedSizeList
                        height={ window.innerHeight * 0.5 }
                        width="100%"
                        itemCount={ this.state.totalRowCount }
                        onItemsRendered={ onItemsRendered }
                        ref={ref}
                        itemSize={ mobile ? 210 : 70 }
                        >
                        {({ index, style }) => (
                            <GamesDataListItem
                                upstyle={ style }
                                key={ index }
                                index={ index }
                                game={ this.state.games[index] }
                                mobile={ mobile } />
                        )}
                    </FixedSizeList>
                )}
            </InfiniteLoader>
        )
    }
}

GamesDataList.contextType = ParamsContext;

export default withMediaQuery(mediaQuery)(GamesDataList);
