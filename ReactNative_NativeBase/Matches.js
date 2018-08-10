import React, { Component } from 'react';
import { Image } from 'react-native';
import { Container, Header, View, DeckSwiper, Card, CardItem, Thumbnail, Text, Left, Body, Icon } from 'native-base';
const cards = [
  {
    text: 'Card One',
    name: 'One',
    image: require('./img/swiper-1.png'),
  },
  .  .  .
];
export default class DeckSwiperAdvancedExample extends Component {
  render() {
    return (
      <Container>
        <Header />
        <View>
          <DeckSwiper
            ref={(c) => this._deckSwiper = c}
            dataSource={cards}
            renderEmpty={() =>
              <View style={{ alignSelf: "center" }}>
                <Text>Over</Text>
              </View>
            renderItem={item =>
              <Card style={{ elevation: 3 }}>
                <CardItem>
                  <Left>
                    <Thumbnail source={item.image} />
                    <Body>
                      <Text>{item.text}</Text>
                      <Text note>NativeBase</Text>
                    </Body>
                  </Left>
                </CardItem>
                <CardItem cardBody>
                  <Image style={{ height: 300, flex: 1 }} source={item.image} />
                </CardItem>
                <CardItem>
                  <Icon name="heart" style={{ color: '#ED4A6A' }} />
                  <Text>{item.name}</Text>
                </CardItem>
              </Card>
            }
          />
        </View>
        <View style={{ flexDirection: "row", flex: 1, position: "absolute", bottom: 50, left: 0, right: 0, justifyContent: 'space-between', padding: 15 }}>
          <Button iconLeft onPress={() => this._deckSwiper._root.swipeLeft()}>
            <Icon name="arrow-back" />
            <Text>Swipe Left</Text>
          </Button>
          <Button iconRight onPress={() => this._deckSwiper._root.swipeRight()}>
            <Icon name="arrow-forward" />
            <Text>Swipe Right</Text>
          </Button>
        </View>
        <Footer>
          <FooterTab>
            <Button badge vertical active>
              <Icon name="paws" /><Text>Matches</Text>
            </Button>
            <Button>
              <Icon name="dog" /><Text>My Pets</Text>
            </Button>
            <Button badge vertical>
              <Badge><Text>4</Text></Badge>
              <Icon name="calendar" /><Text>Events</Text>
            </Button>
            <Button badge vertical>
              <Badge><Text>1</Text></Badge>
              <Icon name="news" /><Text>Blog</Text>
            </Button>
          </FooterTab>
        </Footer>
      </Container>
    );
  }
}