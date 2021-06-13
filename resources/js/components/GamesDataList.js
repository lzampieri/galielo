import React from 'react';
import ParamsContext from '../ParamsContext';
import GamesDataListItem from './GamesDataListItem';
import { FixedSizeList } from 'react-window';
import InfiniteLoader from 'react-window-infinite-loader';

class GamesDataList extends React.PureComponent {

    constructor(props) {
        super(props);
        this.state = {
            totalRowCount: 1000
        }
        this.games= [];
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
        while( finalIndex >= this.games.length )
            await this.downloadPage();
    }

    async downloadPage() {
        let res = await $.get( base_url + '/api/game/some?page=' + ( this.lastPageLoaded + 1 ) );
        this.setState({
            totalRowCount: res.meta.total
        })
        this.games = this.games.concat( res.data );
        this.lastPageLoaded += 1;
        console.log("Downloaded page " + this.lastPageLoaded + ", total of " + this.games.length);
    }

    render() {
        return(
            <InfiniteLoader
                isItemLoaded={ index => ( index < this.games.length ) }
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
                        itemSize={ 46 }
                        >
                        {({ index, style }) => (
                            <GamesDataListItem
                                style={ style }
                                key={ index }
                                index={ index }
                                game={ this.games[index] } />
                        )}
                    </FixedSizeList>
                )}
            </InfiniteLoader>
        )
    }
}

GamesDataList.contextType = ParamsContext;

export default GamesDataList;
