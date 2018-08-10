import React, { Component } from 'react';
import { Image } from 'react-native';
import { Container, Header, View, Card, CardItem, Thumbnail, Text, Left, Body, Icon } from 'native-base';
var FBLoginButton = require('./FBLoginButton');

export default class Index extends Component {
  render() {
    return (
      <Container>
        <Header />
        <View style={{
          justifyContent: 'center',
          alignItems: 'center',
        }}>
        <Image source={{ uri : 'URL' }} />
        <FBLoginButton />
        </View>
        <Footer />
      </Container>
    );
  }
}