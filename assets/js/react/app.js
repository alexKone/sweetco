import React from 'react';
import ReactDOM from 'react-dom';
import {API} from "./utils/api";

class App extends React.Component {
  constructor() {
    super();
    this.state = {
      items: []
    }
  }


  componentDidMount() {
    API.getItems().then(data => {
      console.log(data)
      this.setState({ items: data.items})
    })
  }


  render() {
    return <div>
      <ul>
        {this.state.items.map((item, key) => <li key={key}>{item.title} - {item.price}</li>)}
      </ul>
    </div>
  }
}

ReactDOM.render(<App />, document.getElementById('root'));
