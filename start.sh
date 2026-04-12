#!/bin/bash

MYSQL_DATADIR="/home/runner/mysql-data"
MYSQL_SOCKET="/tmp/mysql.sock"
MYSQL_PORT=3306
MYSQL_ROOT_PASS="IIITDelhi123@"

# Initialize MySQL data directory if not done
if [ ! -d "$MYSQL_DATADIR/mysql" ]; then
    echo "Initializing MySQL data directory..."
    mysqld --initialize-insecure \
           --datadir="$MYSQL_DATADIR" \
           --lower_case_table_names=1 \
           --user=$(whoami) 2>&1
    echo "MySQL data directory initialized."
fi

# Start MySQL if not running
if ! mysqladmin --socket="$MYSQL_SOCKET" ping --silent 2>/dev/null; then
    echo "Starting MySQL..."
    mysqld --datadir="$MYSQL_DATADIR" \
           --socket="$MYSQL_SOCKET" \
           --port="$MYSQL_PORT" \
           --bind-address=127.0.0.1 \
           --lower_case_table_names=1 \
           --mysqlx=0 \
           --daemonize=ON \
           --user=$(whoami) 2>&1

    # Wait for MySQL to start
    for i in $(seq 1 30); do
        if mysqladmin --socket="$MYSQL_SOCKET" ping --silent 2>/dev/null; then
            echo "MySQL started."
            break
        fi
        sleep 1
    done
fi

# Set root password and allow TCP connections
mysql --socket="$MYSQL_SOCKET" -u root --connect-expired-password 2>/dev/null <<ENDSQL
ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY '${MYSQL_ROOT_PASS}';
CREATE USER IF NOT EXISTS 'root'@'127.0.0.1' IDENTIFIED WITH mysql_native_password BY '${MYSQL_ROOT_PASS}';
GRANT ALL PRIVILEGES ON *.* TO 'root'@'127.0.0.1' WITH GRANT OPTION;
FLUSH PRIVILEGES;
ENDSQL

# Import database schema if not already imported
DB_EXISTS=$(mysql --socket="$MYSQL_SOCKET" -u root -p"${MYSQL_ROOT_PASS}" -e "SELECT SCHEMA_NAME FROM information_schema.SCHEMATA WHERE SCHEMA_NAME='quickcart';" 2>/dev/null | grep -c quickcart)
if [ "$DB_EXISTS" -eq "0" ]; then
    echo "Importing database schema..."
    mysql --socket="$MYSQL_SOCKET" -u root -p"${MYSQL_ROOT_PASS}" < /home/runner/workspace/QuickCart/quickcart.sql 2>&1
    echo "Database imported successfully."
fi

echo "Starting PHP server on port 5000..."
cd /home/runner/workspace
exec php -S 0.0.0.0:5000 -t QuickCart/
