# MineChess - PocketMine Chess Plugin

**MineChess** is a PocketMine-MP plugin that brings the game of chess into Minecraft Bedrock. Players can challenge each other to chess matches using a fully interactive in-game chessboard.

## Features
- 🎮 Play chess against other players in Minecraft Bedrock
- 📜 Supports standard chess rules (check, checkmate, castling, en passant, pawn promotion, etc.)
- 🏆 Elo rating system for competitive play
- ⚡ Fast and optimized performance for PocketMine servers
- 📊 Game history logging

## Commands & Permissions
| Command | Description | Permission |
|---------|-------------|------------|
| `/chess challenge <player>` | Challenge a player to a chess match | `minechess.challenge` |
| `/chess accept` | Accept a chess challenge | `minechess.accept` |
| `/chess decline` | Decline a chess challenge | `minechess.decline` |
| `/chess resign` | Forfeit the match | `minechess.resign` |
| `/chess leaderboard` | View top-ranked players | `minechess.leaderboard` |

## Configuration
The `config.yml` file allows you to customize:
- Game timers (optional)
- Elo system settings
- Allowed commands during a game

## Development
Want to contribute? Fork the repo and submit a pull request! Feel free to open issues for bug reports and feature requests.

## License
This project is licensed under the MIT License. See [LICENSE](LICENSE) for details.
